/**
 * StickyButtons
 * A JavaScript class for creating customizable side menus.
 *
 * @version 4.4
 * @license MIT License
 * @author Dmytro Lobov
 * @url https://wow-estore.com/item/sticky-buttons-pro/
 */

'use strict';


class StickyButtons {

    static initialize() {
        document.querySelectorAll(`.sticky-buttons`).forEach((menu) => {
            new StickyButtons(menu);
        });
    }

    constructor(menu) {
        this.element = menu;
        this.links = menu.querySelectorAll(`a, button`);
        this.init();
    }

    init() {
        this.mobileClick();
        this.subMenu();
        this.menuType();
        this.counter();
    }

    mobileClick() {
        if (!this._isMobile()) {
            return;
        }

        if (!this.element.classList.contains('mobile-rule')) {
            return;
        }

        this.links.forEach((link) => {
            let timer;
            link.addEventListener('click', (event) => {

                if (!link.classList.contains('is-active')) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    this.links.forEach((otherLink) => {
                        otherLink.classList.remove('is-active');
                    });

                    link.classList.add('is-active');
                    clearTimeout(timer);

                    setTimeout(() => {
                        link.classList.remove('is-active');
                        link.blur();
                    }, 3000);
                }
            });
        });

        document.addEventListener('click', (event) => {
            if (!this.element.contains(event.target)) {
                this.links.forEach((link) => {
                    link.classList.remove('is-active');
                });
            }
        });

    }

    subMenu() {
        const subMenus = this.element.querySelectorAll('.sb-has-sub');
        if (subMenus.length < 1) {
            return;
        }

        let open = this.element.classList.contains('sub-open-click');

        this.closeSubmenus(subMenus);
        this.openSubmenu(subMenus, open);

        document.addEventListener('click', (event) => {
            if (!this.element.contains(event.target)) {
                this.closeSubmenus(subMenus);
            }
        })
    }

    menuType() {
        if (this.element.classList.contains('is-absolute') || this.element.classList.contains('is-static')) {
            this.element.classList.add('is-hidden');
            const selector = this.element.getAttribute('data-selector');
            const inserted = this.element.getAttribute('data-inserted');
            const element = document.querySelector(selector);
            if (element) {
                const position = window.getComputedStyle(element).position;
                if (this.element.classList.contains('is-absolute') && position === 'static') {
                    element.style.position = 'relative';
                }
                if (inserted === 'prepend') {
                    element.insertBefore(this.element, element.firstChild);
                } else {
                    element.appendChild(this.element);
                }
                this.element.classList.remove('is-hidden');
            }
        }
    }

    counter() {
        this.links.forEach((link) => {
            const counter = link.querySelector(`.sb-count`);

            if (!counter) {
                return;
            }

            const li = link.closest(`li`);

            if (!li.hasAttribute('data-item')) {
                return;
            }

            let checkReaction = false;

            const item_data = li.getAttribute('data-item');

            if (localStorage.getItem(item_data)) {
                if (link.hasAttribute('data-action') && link.getAttribute('data-action') === 'reaction') {
                    checkReaction = true;
                    link.setAttribute('data-checked', 'true');
                    this._rections(checkReaction);
                }
                return;
            }

            link.addEventListener('click', (event) => {

                if (localStorage.getItem(item_data)) {
                    return;
                }

                let counterVal = parseInt(counter.innerText) + 1;

                fetch(sb_obj.url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: new URLSearchParams({
                        action: 'sticky_buttons_counter',
                        nonce: sb_obj.nonce,
                        item_data: item_data,
                        count: counterVal,
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            const counters = link.querySelectorAll(`.sb-count`);
                            counters.forEach((box) => {
                                box.innerText = data.data.count;
                            });
                            localStorage.setItem(item_data, 'true');
                            if (link.hasAttribute('data-action') && link.getAttribute('data-action') === 'reaction') {
                                checkReaction = true;
                                link.setAttribute('data-checked', 'true');
                                this._rections(checkReaction);
                            }

                        }
                    })
                    .catch(err => console.error(err));
            })


        })
    }

    _rections(check = false) {
        if (check === true) {
            this.links.forEach((link) => {
                if (link.hasAttribute('data-action') && link.getAttribute('data-action') === 'reaction') {
                    link.setAttribute('disabled', 'disabled');
                }
            });
        }
    }

    closeSubmenus(subMenus) {
        subMenus.forEach((subMenu) => {
            subMenu.classList.remove('is-active');
        })
    }

    openSubmenu(subMenus, open) {
        this.links.forEach((link) => {

            if (open === true || this._isMobile()) {

                link.addEventListener('click', (event) => {
                    this.closeSubmenus(subMenus);
                    if (link.classList.contains('sb-open-sub')) {
                        const li = link.closest('.sb-has-sub');
                        li.classList.add('is-active');
                    }
                })
            }

        });
    }


    _isMobile() {
        return /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ||
            window.innerWidth <= 768 ||
            'ontouchstart' in window ||
            navigator.maxTouchPoints > 0;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    StickyButtons.initialize();
});
