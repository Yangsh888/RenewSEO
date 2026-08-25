(function () {
    'use strict';

    if (window.TypechoTabs && typeof window.TypechoTabs.init === 'function') {
        window.TypechoTabs.init({
            labelGroupSelector: '.renewseo-list-item, .renewseo-block-item, .renewseo-field',
            labelTextSelector: '.renewseo-list-item-title, .renewseo-field > span'
        });
    }

    const toggles = [
        { id: 'baiduEnable', groupClass: 'group-baidu-push' },
        { id: 'indexNowEnable', groupClass: 'group-indexnow-push' },
        { id: 'bingEnable', groupClass: 'group-bing-push' }
    ];

    toggles.forEach((toggle) => {
        const checkbox = document.getElementById(toggle.id);
        if (!checkbox) {
            return;
        }

        const groupElements = document.querySelectorAll('.' + toggle.groupClass);
        const updateVisibility = (checked) => {
            groupElements.forEach((el) => {
                el.style.display = checked ? '' : 'none';
            });
        };

        updateVisibility(checkbox.checked);
        checkbox.addEventListener('change', function () {
            updateVisibility(this.checked);
        });
    });
})();
