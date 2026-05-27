(function ($) {
    'use strict';

    const POLL_INTERVAL = 10000;
    let pollTimer = null;
    let currentListId = null;
    let currentListUrl = null;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    function showToast() { return; }

    function clearFormErrors($form) {
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.ajax-error-feedback, .ajax-error-summary').remove();
    }

    function showFormErrors($form, errors) {
        clearFormErrors($form);
        $.each(errors, function (field, messages) {
            const $input = $form.find('[name="' + field + '"]');
            if ($input.length) {
                $input.addClass('is-invalid');
                $input.after('<div class="ajax-error-feedback invalid-feedback d-block">' + messages[0] + '</div>');
            } else {
                if (!$form.find('.ajax-error-summary').length) {
                    $form.prepend(
                        '<div class="ajax-error-summary alert alert-danger alert-dismissible">' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '<ul class="mb-0 mt-1" id="ajaxErrorList"></ul></div>'
                    );
                }
                $form.find('#ajaxErrorList').append('<li>' + messages[0] + '</li>');
            }
        });
    }

    function setButtonLoading($btn, text) {
        $btn.data('orig', $btn.html()).prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm me-1"></span>' + (text || 'Processing…'));
    }

    function resetButton($btn) {
        const orig = $btn.data('orig');
        $btn.prop('disabled', false);
        if (orig !== undefined) { $btn.html(orig); }
    }

    function getPathFromUrl(url) {
        try { return new URL(url, window.location.origin).pathname; }
        catch (e) { return String(url || ''); }
    }

    function isAjaxableLink(link) {
        const href = link.getAttribute('href');
        if (!href || href === '#' || href.indexOf('javascript:') === 0) { return false; }
        if (link.target && link.target !== '_self') { return false; }
        if (link.hasAttribute('download')) { return false; }
        if ($(link).data('no-ajax')) { return false; }
        if (href.indexOf('mailto:') === 0 || href.indexOf('tel:') === 0) { return false; }
        try { return new URL(href, window.location.origin).origin === window.location.origin; }
        catch (e) { return false; }
    }

    function loadTable(id, url, extraParams) {
        const $table = $('#' + id);
        if (!$table.length || !url) { return; }

        const searchVal = $table.closest('[data-ajax-search-id]').length
            ? $('#' + $table.closest('[data-ajax-search-id]').data('ajax-search-id')).val()
            : ($('#studentSearch').val() || '');

        const params = $.extend({ table: 1, _: Date.now(), search: searchVal }, extraParams || {});

        $table.css('opacity', '0.55');

        const xhrKey = '_xhr_' + id;
        if (window[xhrKey] && window[xhrKey].readyState !== 4) { window[xhrKey].abort(); }

        window[xhrKey] = $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html',
            cache: false,
            data: params,
            success: function (html) { if ($('#' + id).length) { $('#' + id).html(html); } },
            error: function (xhr, status) { if (status === 'abort') { return; } },
            complete: function () { if ($('#' + id).length) { $('#' + id).css('opacity', '1'); } }
        });
    }

    function loadStudents(page, search) {
        const params = {};
        if (page !== undefined) { params.page = page; }
        if (search !== undefined) { params.search = search; }
        loadTable('studentTable', '/students', params);
    }

    window.loadStudents = loadStudents;
    window.loadTable = loadTable;

    function detectAndStartPolling() {
        const $listEl = $('[data-ajax-list-url]').first();
        if (!$listEl.length) { return; }
        currentListId = $listEl.attr('id');
        currentListUrl = $listEl.data('ajax-list-url');
        startPolling();
    }

    function startPolling() {
        stopPolling();
        if (!currentListId || !currentListUrl) { return; }
        pollTimer = setInterval(function () {
            if ($('#' + currentListId).length) { loadTable(currentListId, currentListUrl); }
            else { stopPolling(); }
        }, POLL_INTERVAL);
    }

    function stopPolling() { if (pollTimer !== null) { clearInterval(pollTimer); pollTimer = null; } }

    window.startStudentPolling = startPolling;
    window.stopStudentPolling = stopPolling;

    function getPageContent(html) {
        const doc = new DOMParser().parseFromString(html, 'text/html');
        const el = doc.querySelector('#ajaxPageContent');
        return el ? el.innerHTML : html;
    }

    function ajaxNavigate(url, options) {
        options = options || {};
        const target = options.target || '#ajaxPageContent';
        const $target = $(target);

        stopPolling();
        if (!$target.length) { window.location.href = url; return; }

        $target.css('opacity', '0.45');
        if (window.mfdPageRequest && window.mfdPageRequest.readyState !== 4) { window.mfdPageRequest.abort(); }

        let requestUrl = url;
        let reqHash = '';
        try {
            const uObj = new URL(url, window.location.origin);
            reqHash = uObj.hash || '';
            uObj.searchParams.set('_', Date.now());
            requestUrl = uObj.toString();
        } catch (e) {
            requestUrl = url + (url.indexOf('?') === -1 ? '?' : '&') + '_=' + Date.now();
        }

        window.mfdPageRequest = $.ajax({
            url: requestUrl,
            type: 'GET',
            dataType: 'html',
            cache: false,
            success: function (html, status, xhr) {
                let finalUrl = (xhr && xhr.responseURL) ? xhr.responseURL : url;
                if (reqHash && String(finalUrl).indexOf('#') === -1) { finalUrl = String(finalUrl) + reqHash; }

                $target.html(getPageContent(html));

                const titleMatch = html.match(/<title[^>]*>(.*?)<\/title>/i);
                if (titleMatch) { document.title = $('<textarea/>').html(titleMatch[1]).text(); }

                if (options.pushState !== false && window.location.href !== finalUrl) {
                    window.history.pushState({ ajaxUrl: finalUrl, target: target }, document.title, finalUrl);
                }

                setTimeout(function () {
                    currentListId = null; currentListUrl = null; detectAndStartPolling();
                    if (currentListId && currentListUrl) { loadTable(currentListId, currentListUrl); }
                }, 50);

                if (reqHash) {
                    const el = document.querySelector(reqHash);
                    if (el) { el.scrollIntoView({ behavior: 'smooth', block: 'start' }); return; }
                }
                window.scrollTo({ top: 0, behavior: 'smooth' });
            },
            error: function (xhr, status) { if (status === 'abort') { return; } setTimeout(function () { window.location.href = url; }, 300); },
            complete: function () { $target.css('opacity', '1'); }
        });
    }

    window.ajaxNavigate = ajaxNavigate;

    const DELETE_MODAL_HTML =
        '<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">' +
        '  <div class="modal-dialog modal-dialog-centered modal-sm">' +
        '    <div class="modal-content" style="border:1px solid #d9efff;border-radius:18px;overflow:hidden;box-shadow:0 20px 45px rgba(14,165,255,0.18);">' +
        '      <div class="modal-header" style="background:linear-gradient(135deg,#0ea5ff,#38bdf8);color:#fff;border-bottom:0;padding:1rem 1.1rem;">' +
        '        <div class="d-flex align-items-center gap-2">' +
        '          <div style="width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,0.16);display:flex;align-items:center;justify-content:center;flex-shrink:0;">' +
        '            <i class="fas fa-trash"></i>' +
        '          </div>' +
        '          <div>' +
        '            <h5 class="modal-title mb-0" style="font-family:\'Plus Jakarta Sans\',sans-serif;font-size:1rem;font-weight:800;line-height:1;">Delete record?</h5>' +
        '            <small style="display:block;color:rgba(255,255,255,0.82);font-size:0.74rem;margin-top:0.15rem;">This action cannot be undone</small>' +
        '          </div>' +
        '        </div>' +
        '        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>' +
        '      </div>' +
        '      <div class="modal-body" id="deleteModalBody" style="padding:1rem 1.1rem;color:#334155;font-size:0.92rem;line-height:1.6;background:#fff;"></div>' +
        '      <div class="modal-footer" style="border-top:1px solid #e8f4ff;background:#f8fcff;padding:0.9rem 1.1rem;">' +
        '        <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="font-weight:700;border:1px solid #cdeeff;color:#0369a1;background:#fff;">Cancel</button>' +
        '        <button type="button" class="btn btn-danger" id="confirmDeleteBtn" style="font-weight:700;background:#ef4444;border-color:#ef4444;">' +
        '          <i class="fas fa-trash me-1"></i>Delete' +
        '        </button>' +
        '      </div>' +
        '    </div>' +
        '  </div>' +
        '</div>';

    function ensureDeleteModal() { if (!$('#deleteModal').length) { $('body').append(DELETE_MODAL_HTML); } }

    function ajaxDelete(deleteUrl, name, $row, listId, listUrl) {
        const label = name ? '"' + name + '"' : 'this record';

        const doDelete = function () {
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                dataType: 'json',
                headers: { 'Accept': 'application/json' },
                success: function () {
                    const hasListOnPage = !!(listId && $('#' + listId).length);

                    if ($row && $row.length) {
                        $row.css('opacity', '0.3');
                        setTimeout(function () {
                            $row.remove();
                            if (listId && listUrl) { loadTable(listId, listUrl); }
                            else if (currentListId && currentListUrl) { loadTable(currentListId, currentListUrl); }
                        }, 150);
                    } else {
                        if (hasListOnPage && listId && listUrl) { loadTable(listId, listUrl); }
                        else if (listUrl) { ajaxNavigate(listUrl, { target: '#ajaxPageContent' }); }
                    }
                },
                error: function (xhr) {
                    const d = xhr.responseJSON;
                    alert((d && d.error) ? d.error : 'Delete failed. Please try again.');
                }
            });
        };

        if (!window.bootstrap || !bootstrap.Modal) {
            if (confirm('Delete ' + label + '? This cannot be undone.')) { doDelete(); }
            return;
        }

        ensureDeleteModal();
        $('#deleteModalBody').text('Are you sure you want to delete ' + label + '? This cannot be undone.');

        const $modal = $('#deleteModal');
        const $btn = $('#confirmDeleteBtn');
        const modal = new bootstrap.Modal($modal[0]);

        $btn.off('click').on('click', function () {
            setButtonLoading($btn, 'Deleting…');
            modal.hide();
            doDelete();
            resetButton($btn);
        });

        modal.show();
    }

    window.deleteStudent = function (id, name, ctx) {
        ctx = ctx || {};
        ajaxDelete('/students/' + id, name, ctx.$row, 'studentTable', '/students');
    };

    $(function () {
        (function () {
            const $c = $('#ajaxPageContent').first();
            const $n = $c.find('#ajaxPageContent').last();
            if ($n.length) { $c.html($n.html()); }
            $c.children('nav.navbar, footer').remove();
        })();

        $(document).off('click.mfdAjax').off('submit.mfdAjax').off('input.mfdAjax');

        $(document).on('click.mfdAjax', 'a[data-ajax-link="true"]', function (e) {
            if (e.ctrlKey || e.metaKey || e.shiftKey || e.altKey || e.which === 2) { return; }
            if ($(this).closest('.ajax-pagination').length) { return; }
            if (!isAjaxableLink(this)) { return; }
            e.preventDefault();
            stopPolling();
            ajaxNavigate(this.href, { target: $(this).data('target') || '#ajaxPageContent' });
        });

        window.onpopstate = function () { stopPolling(); ajaxNavigate(window.location.href, { pushState: false }); };

        $(document).on('submit.mfdAjax', 'form[data-ajax="true"]', function (e) {
            e.preventDefault();

            const $form = $(this);
            const $submit = $form.find('button[type="submit"]');
            const showLoad = $form.data('loading') !== false;

            if ($form.data('submitting')) { return; }
            $form.data('submitting', true);

            clearFormErrors($form);
            if (showLoad) { setButtonLoading($submit, 'Saving…'); }

            $.ajax({
                url: $form.attr('action'),
                type: ($form.attr('method') || 'POST').toUpperCase(),
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType: 'json',
                timeout: 15000,

                success: function (data) {
                    $form.data('submitting', false);
                    if (showLoad) { resetButton($submit); }

                    const redirectTo = data.redirect_url || $form.data('redirect') || null;
                    let delay = parseInt($form.data('redirect-delay'), 10);
                    if (isNaN(delay)) { delay = 0; }

                    if (redirectTo) {
                        setTimeout(function () { ajaxNavigate(redirectTo, { target: '#ajaxPageContent' }); }, delay);
                    } else if ($form.data('reset-on-success')) {
                        $form[0].reset();
                        clearFormErrors($form);
                        if (currentListId && currentListUrl) { loadTable(currentListId, currentListUrl); }
                    }
                },

                error: function (xhr, status) {
                    $form.data('submitting', false);
                    if (showLoad) { resetButton($submit); }

                    const data = xhr.responseJSON;
                    if (xhr.status === 422 && data && data.errors) { showFormErrors($form, data.errors); }
                    else if (status === 'timeout') { alert('Request timed out. Please check if it was saved.'); }
                    else { alert((data && data.error) ? data.error : 'An error occurred. Please try again.'); }
                },

                complete: function () { $form.data('submitting', false); if (showLoad) { resetButton($submit); } }
            });
        });

        $(document).on('click.mfdAjax', '.js-ajax-delete', function (e) {
            e.preventDefault();
            const $btn = $(this);
            const delUrl = $btn.data('url');
            const name = $btn.data('name');
            const listId = $btn.data('list-id') || currentListId;
            const listUrl = $btn.data('list-url') || currentListUrl;
            if (!delUrl) { return; }
            ajaxDelete(delUrl, name, $btn.closest('tr'), listId, listUrl);
        });

        $(document).on('click.mfdAjax', '.js-delete-student', function (e) {
            e.preventDefault();
            const $btn = $(this);
            ajaxDelete('/students/' + $btn.data('id'), $btn.data('name'), $btn.closest('tr'), 'studentTable', '/students');
        });

        $(document).on('click.mfdAjax', '.ajax-pagination a', function (e) {
            e.preventDefault();
            const href = $(this).attr('href');
            if (!href || href === '#') { return; }
            const params = {};
            try { const u = new URL(href, window.location.origin); params.page = u.searchParams.get('page') || 1; } catch (ex) {}
            if (currentListId && currentListUrl) { loadTable(currentListId, currentListUrl, params); }
        });

        let searchTimer = null;
        $(document).on('input.mfdAjax', '[data-ajax-search-for], #studentSearch', function () {
            clearTimeout(searchTimer);
            const $input = $(this);
            const tableId = $input.data('ajax-search-for') || 'studentTable';
            const listUrl = $('#' + tableId).data('ajax-list-url') || '/students';
            const query = $input.val();
            searchTimer = setTimeout(function () { loadTable(tableId, listUrl, { page: 1, search: query }); }, 400);
        });

        detectAndStartPolling();
        if (currentListId && currentListUrl) { loadTable(currentListId, currentListUrl); }

    });

})(jQuery);
