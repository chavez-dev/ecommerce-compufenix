// SIDEBAR DROPDOWN
const allDropdown = document.querySelectorAll('#sidebar .side-dropdown');
const sidebar = document.getElementById('sidebar');

// Para cada elemento desplegable en la barra lateral
allDropdown.forEach(item => {
    // Obtener el primer enlace dentro del elemento desplegable
    const a = item.parentElement.querySelector('a:first-child');

    // Agregar un evento de clic al enlace
    a.addEventListener('click', function (e) {
        // Evitar el comportamiento predeterminado del enlace (por ejemplo, seguir el enlace)
        e.preventDefault();

        // Si el enlace actual no tiene la clase 'active'
        if (!this.classList.contains('active')) {
            // Cerrar todos los desplegables abiertos y eliminar la clase 'active'
            allDropdown.forEach(i => {
                const aLink = i.parentElement.querySelector('a:first-child');

                // Remover la clase 'active' del enlace
                aLink.classList.remove('active');
                
                // Remover la clase 'show' del desplegable
                i.classList.remove('show');
            });
        }

        // Alternar la clase 'active' en el enlace actual
        this.classList.toggle('active');
        
        // Alternar la clase 'show' en el desplegable actual
        item.classList.toggle('show');
    });
});

// Verificar si estamos en la página producto.php
if (window.location.pathname.includes('/admin/producto.php')) {
    // Obtener el elemento del desplegable
    const dropdown1 = document.querySelector('#sidebar .list-productos');
    const listaProductosLink1 = dropdown1.querySelector('a[href="../admin/producto.php"]');
    dropdown1.classList.add('show');
    listaProductosLink1.classList.add('active');
}
if (window.location.pathname.includes('/admin/categoria.php')) {
    // Obtener el elemento del desplegable
    const dropdown2 = document.querySelector('#sidebar .list-productos');
    const listaProductosLink2 = dropdown2.querySelector('a[href="../admin/categoria.php"]');
    dropdown2.classList.add('show');
    listaProductosLink2.classList.add('active');
}



// LISTA DESPLESGABLE DE INVENTARIO
if (window.location.pathname.includes('/admin/inventario.php')) {
	// Obtener el elemento del desplegable
	const dropdown = document.querySelector('#sidebar .list-inventario');
	const listaProductosLink = dropdown.querySelector('a[href="../admin/inventario.php"]');
	dropdown.classList.add('show');
	listaProductosLink.classList.add('active');
}
if (window.location.pathname.includes('/admin/estado.php')) {
    // Obtener el elemento del desplegable
    const dropdown = document.querySelector('#sidebar .list-inventario');
    const listaProductosLink = dropdown.querySelector('a[href="../admin/estado.php"]');
    dropdown.classList.add('show');
    listaProductosLink.classList.add('active');
}

// LISTA DESPLEGABLE DE CONFIGURACION
if (window.location.pathname.includes('/admin/tienda.php')) {
    // Obtener el elemento del desplegable
    const dropdown = document.querySelector('#sidebar .list-configuration');
    const listaProductosLink = dropdown.querySelector('a[href="../admin/tienda.php"]');
    dropdown.classList.add('show');
    listaProductosLink.classList.add('active');
}
if (window.location.pathname.includes('/admin/permiso.php')) {
    // Obtener el elemento del desplegable
    const dropdown = document.querySelector('#sidebar .list-configuration');
    const listaProductosLink = dropdown.querySelector('a[href="../admin/permiso.php"]');
    dropdown.classList.add('show');
    listaProductosLink.classList.add('active');
}
if (window.location.pathname.includes('/admin/serie.php')) {
    // Obtener el elemento del desplegable
    const dropdown = document.querySelector('#sidebar .list-configuration');
    const listaProductosLink = dropdown.querySelector('a[href="../admin/serie.php"]');
    dropdown.classList.add('show');
    listaProductosLink.classList.add('active');
}




// SIDEBAR COLLAPSE
const toggleSidebar = document.querySelector('nav .toggle-sidebar');
const allSideDivider = document.querySelectorAll('#sidebar .divider');

if(sidebar.classList.contains('hide')) {
	allSideDivider.forEach(item=> {
		item.textContent = '-'
	})
	allDropdown.forEach(item=> {
		const a = item.parentElement.querySelector('a:first-child');
		a.classList.remove('active');
		item.classList.remove('show');
	})
} else {
	allSideDivider.forEach(item=> {
		item.textContent = item.dataset.text;
	})
}

toggleSidebar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');

	if(sidebar.classList.contains('hide')) {
		allSideDivider.forEach(item=> {
			item.textContent = '-'
		})

		allDropdown.forEach(item=> {
			const a = item.parentElement.querySelector('a:first-child');
			a.classList.remove('active');
			item.classList.remove('show');
		})
	} else {
		allSideDivider.forEach(item=> {
			item.textContent = item.dataset.text;
		})
	}
})


// Verificar el tamaño de la pantalla y hacer clic en el icono de hamburguesa si es un móvil
window.addEventListener('load', function () {
    if (window.innerWidth <= 768) {
        toggleSidebar.click();  // Simula el clic en el icono de hamburguesa
    }
})

sidebar.addEventListener('mouseleave', function () {
	if(this.classList.contains('hide')) {
		allDropdown.forEach(item=> {
			const a = item.parentElement.querySelector('a:first-child');
			a.classList.remove('active');
			item.classList.remove('show');
		})
		allSideDivider.forEach(item=> {
			item.textContent = '-'
		})
	}
})



sidebar.addEventListener('mouseenter', function () {
	if(this.classList.contains('hide')) {
		allDropdown.forEach(item=> {
			const a = item.parentElement.querySelector('a:first-child');
			a.classList.remove('active');
			item.classList.remove('show');
		})
		allSideDivider.forEach(item=> {
			item.textContent = item.dataset.text;
		})
	}
})




// PROFILE DROPDOWN
const profile = document.querySelector('nav .profile');
const imgProfile = profile.querySelector('img');
const dropdownProfile = profile.querySelector('.profile-link');

imgProfile.addEventListener('click', function () {
	dropdownProfile.classList.toggle('show');
})
