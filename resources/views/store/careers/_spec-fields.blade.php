<div class="panel-card mt-3">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-list-check"></i> Application Fields</h2>
        <button type="button" id="add-spec-btn" class="btn-outline-sm"><i class="bi bi-plus-lg"></i> Add Field</button>
    </div>
    <div class="panel-card-body">
        <p class="text-muted small">Define what a client must fill out to apply for this job — name, phone, CV file, etc. "Show in Report" controls whether this field's answer appears in the applicants list.</p>
        <div id="spec-list"></div>
        <p class="text-muted small mb-0 d-none" id="spec-empty">No application fields yet — click "Add Field" to add one.</p>
    </div>
</div>

<template id="spec-row-template">
    <div class="spec-row border rounded p-3 mb-2">
        <input type="hidden" class="spec-id" data-name="id" value="">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Field Name</label>
                <input type="text" class="form-control spec-name" data-name="name" placeholder="e.g. Full Name, CV" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Type</label>
                <select class="form-select spec-type" data-name="type">
                    <option value="1">Text</option>
                    <option value="2">Dropdown (Select)</option>
                    <option value="3">File Upload</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Required?</label>
                <select class="form-select spec-required" data-name="validation">
                    <option value="nullable">Optional</option>
                    <option value="required">Required</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Show in Report</label>
                <select class="form-select spec-report" data-name="available_report">
                    <option value="2">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn-icon-sm btn-delete remove-spec-btn" title="Remove field">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
            <div class="col-12 spec-values-wrap" style="display:none;">
                <label class="form-label">Dropdown Options (one per line)</label>
                <textarea class="form-control spec-values" data-name="values_text" rows="3" placeholder="Option A&#10;Option B"></textarea>
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script>
(function() {
    var list = document.getElementById('spec-list');
    var emptyMsg = document.getElementById('spec-empty');
    var addBtn = document.getElementById('add-spec-btn');
    var template = document.getElementById('spec-row-template');
    var specIndex = 0;

    function refreshEmptyMessage() {
        emptyMsg.classList.toggle('d-none', list.children.length !== 0);
    }

    function toggleValuesVisibility(row) {
        var isSelect = row.querySelector('.spec-type').value === '2';
        row.querySelector('.spec-values-wrap').style.display = isSelect ? '' : 'none';
    }

    function addRow(data) {
        data = data || {};
        var index = specIndex++;
        var fragment = template.content.cloneNode(true);
        var row = fragment.querySelector('.spec-row');

        row.querySelectorAll('[data-name]').forEach(function (el) {
            el.name = 'specifications[' + index + '][' + el.getAttribute('data-name') + ']';
        });

        if (data.id) row.querySelector('.spec-id').value = data.id;
        if (data.name) row.querySelector('.spec-name').value = data.name;
        if (data.type) row.querySelector('.spec-type').value = data.type;
        if (data.validation) row.querySelector('.spec-required').value = data.validation;
        if (data.available_report) row.querySelector('.spec-report').value = data.available_report;
        if (data.values_text) row.querySelector('.spec-values').value = data.values_text;

        toggleValuesVisibility(row);

        row.querySelector('.spec-type').addEventListener('change', function () {
            toggleValuesVisibility(row);
        });

        row.querySelector('.remove-spec-btn').addEventListener('click', function () {
            row.remove();
            refreshEmptyMessage();
        });

        list.appendChild(row);
        refreshEmptyMessage();
    }

    addBtn.addEventListener('click', function () {
        addRow();
    });

    // Wait for DOMContentLoaded so the page's seed script has run regardless of push order.
    document.addEventListener('DOMContentLoaded', function () {
        (window.__existingSpecifications || []).forEach(function (spec) {
            addRow(spec);
        });

        refreshEmptyMessage();
    });
})();
</script>
@endpush
