<style>
    .document-admin-page .access-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.42rem 0.68rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        line-height: 1.25;
        white-space: normal;
    }

    .document-admin-page .access-badge.is-all {
        background: rgba(47, 128, 237, 0.1);
        color: #2368c8;
    }

    .document-admin-page .access-badge.is-admin {
        background: #fdecec;
        color: #e34d4d;
    }

    .document-admin-page .access-badge.is-manager {
        background: #fff7e6;
        color: #b7791f;
    }

    .document-admin-page .access-badge.is-staff-admin {
        background: #e9f8f0;
        color: #16a163;
    }

    .document-admin-page .document-file-summary {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.85rem;
        border: 1px solid #e5edf7;
        border-radius: 14px;
        background: #f8fbff;
    }

    .document-admin-page .document-file-summary-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        flex: 0 0 auto;
        border-radius: 999px;
        background: linear-gradient(135deg, #2f80ed, #2368c8);
        color: #fff;
        font-size: 1.15rem;
    }

    .document-admin-page .min-w-0 {
        min-width: 0;
    }

    .document-admin-page .document-role-picker {
        padding: 0.75rem;
        border: 1px solid #e5edf7;
        border-radius: 16px;
        background: #f8fbff;
    }

    .document-admin-page .document-role-picker.is-invalid {
        border-color: #ff3e1d;
    }

    .document-admin-page .document-role-search {
        position: relative;
        margin: 0.7rem 0;
    }

    .document-admin-page .document-role-search i {
        position: absolute;
        top: 50%;
        left: 0.9rem;
        z-index: 1;
        color: #718096;
        transform: translateY(-50%);
    }

    .document-admin-page .document-role-search .form-control {
        padding-left: 2.35rem;
        border-radius: 999px;
    }

    .document-admin-page .document-role-list {
        display: grid;
        gap: 0.45rem;
        max-height: 290px;
        overflow: auto;
        padding-right: 0.2rem;
    }

    .document-admin-page .document-role-option {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        min-height: 40px;
        margin: 0;
        padding: 0.58rem 0.7rem;
        border-radius: 12px;
        color: #28364a;
        cursor: pointer;
        transition: background 0.18s ease, color 0.18s ease;
    }

    .document-admin-page .document-role-option:hover {
        background: #edf5ff;
    }

    .document-admin-page .document-role-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .document-admin-page .document-role-check {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        flex: 0 0 auto;
        border: 1px solid #c9d8eb;
        border-radius: 999px;
        color: transparent;
        font-size: 0.82rem;
    }

    .document-admin-page .document-role-option input:checked + .document-role-check {
        border-color: #2f80ed;
        background: #2f80ed;
        color: #fff;
    }

    .document-admin-page .document-role-option:has(input:checked) {
        background: #e8f2ff;
        color: #2368c8;
        font-weight: 700;
    }

    .document-admin-page .document-role-option.is-hidden {
        display: none;
    }

    html.aps-dark .document-admin-page .document-file-summary {
        border-color: #263653;
        background: #16243a;
    }

    html.aps-dark .document-admin-page .document-role-picker {
        border-color: #263653;
        background: #111c31;
    }

    html.aps-dark .document-admin-page .document-role-option {
        color: #e7f0fb;
    }

    html.aps-dark .document-admin-page .document-role-option:hover,
    html.aps-dark .document-admin-page .document-role-option:has(input:checked) {
        background: #162842;
        color: #8fc1ff;
    }

    html.aps-dark .document-admin-page .document-role-check {
        border-color: #315071;
    }

    html.aps-dark .document-admin-page .access-badge.is-all {
        background: rgba(47, 128, 237, 0.16);
        color: #8fc1ff;
    }

    html.aps-dark .document-admin-page .access-badge.is-admin {
        background: rgba(239, 68, 68, 0.14);
        color: #fb7185;
    }

    html.aps-dark .document-admin-page .access-badge.is-manager {
        background: rgba(245, 158, 11, 0.16);
        color: #fbbf24;
    }

    html.aps-dark .document-admin-page .access-badge.is-staff-admin {
        background: rgba(34, 197, 94, 0.14);
        color: #6ee7a8;
    }
</style>
