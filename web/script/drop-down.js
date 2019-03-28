/* drop-down */

window.addEventListener('click', function(e) {
    var target = e.target,
        parentTarget = e.target.parentNode;
    
    if(target.classList.contains('drop-down__btn') || parentTarget.classList.contains('drop-down__btn')) {
        var btn = (parentTarget.classList.contains('drop-down__btn') ? parentTarget: target),
            idMenu = btn.dataset.menu;
            
        if(idMenu) {
            var menu = document.getElementById(idMenu);
        } else {
            var menu = btn.parentNode.getElementsByClassName('drop-down__sub')[0];
        }
        
        if(menu.style.display == 'none' || menu.style.display.length == 0) {
            menu.style.display = 'block';
        } else {
            menu.style.display = 'none';
        }
    } else {
        var menus = document.getElementsByClassName('drop-down__sub');

        for(var i = 0; i < menus.length; i++) {
            menus[i].style.display = 'none';
        }
    }
});