<script>
    function initDocumentRolePicker() {
        document.querySelectorAll('.document-role-picker').forEach(function(picker) {
            const allCheckbox = picker.querySelector('[data-document-role-all]');
            const roleCheckboxes = picker.querySelectorAll('[data-document-role-item]');
            const searchInput = picker.querySelector('[data-document-role-search]');
            const roleOptions = picker.querySelectorAll('[data-document-role-option]');

            if (!allCheckbox) {
                return;
            }

            const syncAll = function() {
                if (allCheckbox.checked) {
                    roleCheckboxes.forEach(function(checkbox) {
                        checkbox.checked = false;
                    });
                }
            };

            allCheckbox.addEventListener('change', syncAll);

            roleCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    if (checkbox.checked) {
                        allCheckbox.checked = false;
                    }
                });
            });

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const keyword = searchInput.value.trim().toLowerCase();

                    roleOptions.forEach(function(option) {
                        const label = option.dataset.roleLabel || '';
                        option.classList.toggle('is-hidden', keyword !== '' && !label.includes(keyword));
                    });
                });
            }

            syncAll();
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDocumentRolePicker);
    } else {
        initDocumentRolePicker();
    }
</script>
