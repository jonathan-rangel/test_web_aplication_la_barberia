let step = 1;
const start_step = 1;
const final_step = 4;

const reservation = {
    id: '',
    name: '',
    date: '',
    time: '',
    services: [],
    products: []
}

document.addEventListener('DOMContentLoaded', function() {
    startApp();
});

function startApp() {
    showSection(); //Muestra y oculta las secciones
    tabs(); //Cambiar las secciones al presionar los tabs
    pagerButtons(); //Agregar o quitar los botones del paginador
    
    prevPage();
    nextPage();
    getAPIServices(); //Consulta la BD

    saveClientId();
    saveClienName();
    saveDate();
    saveTime();

    showSummary();
}

function showSection() {
    //Ocultar la sección que ya contenga 'show-section'
    const prev_section = document.querySelector('.show-section');
    
    if(prev_section)
        prev_section.classList.remove('show-section');

    //Seleccionar la sección con el paso
    const section = document.querySelector(`#step-${step}`);
    section.classList.add('show-section');

    //Resaltar el tab actual
    const prev_tab = document.querySelector('.current-tab');
    if(prev_tab)
        prev_tab.classList.remove('current-tab');

    const tab = document.querySelector(`[data-step="${step}"]`);
    tab.classList.add('current-tab');
}

function tabs() {
    const buttons = document.querySelectorAll('.tabs button');

    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            step = parseInt(e.target.dataset.step);
            
            showSection();
            pagerButtons();
        })
    });
}

function pagerButtons() {
    const prev_page = document.querySelector('#previous');
    const next_page = document.querySelector('#next');

    if(step === 1) {
        prev_page.classList.add('hide');
        next_page.classList.remove('hide');
    }
    else if(step === 4) {
        prev_page.classList.remove('hide');
        next_page.classList.add('hide');
        showSummary();
    } else {
        prev_page.classList.remove('hide');
        next_page.classList.remove('hide');
    }
    if(step === 5) {
        prev_page.classList.add('hide');
        next_page.classList.add('hide');
    }
    if(step === 3)
        getAPIProducts();
    showSection();
}

function prevPage() {
    const prev_page = document.querySelector('#previous');
    prev_page.addEventListener('click', function() {
        if(step <= start_step) return;
        else {
            step --;
            pagerButtons();
        }  
    });
}

function nextPage() {
    const next_page = document.querySelector('#next');
    next_page.addEventListener('click', function() {
        if(step >= final_step) return;
        else {
            step ++;
            pagerButtons();
        } 
    });
}

async function getAPIServices() {
    try {
        const url = 'http://localhost:3000/api/services';
        const result = await fetch(url);
        const services = await result.json();
        showServices(services);
    } catch (error) {
        console.log(error);
    }
}

async function getAPIProducts() {
    try {
        const url = 'http://localhost:3000/api/products';
        const result = await fetch(url);
        const products = await result.json();
        showProducts(products);
    } catch (error) {
        console.log(error);
    }
}

function showProducts(products) {
    const show_produ = document.querySelector('#products').textContent;
    if(!show_produ) {
        products.forEach(product => {
            const {id, name, price, description, image} = product;
            
            const product_name = document.createElement('P');
            product_name.classList.add('product-name');
            product_name.textContent = name;

            // const container_image = document.createElement('DIV');
            // container_image.classList.add('container-image');

            const image_div = document.createElement('IMG');
            image_div.src = image;

            // container_image.appendChild(image_div);
    
            const product_price = document.createElement('P');
            product_price.classList.add('product-price');
            product_price.textContent = `$${price}`;
    
            const product_div = document.createElement('DIV');
            product_div.classList.add('product');
            product_div.dataset.productId = id;
            product_div.onclick = function() {
                selectProduct(product);
            }
    
            product_div.appendChild(product_name);
            product_div.appendChild(image_div);
            product_div.appendChild(product_price);
    
            document.querySelector('#products').appendChild(product_div);
        })
    }
}

function showServices(services) {
    services.forEach(service => {
        const {id, name, price, description} = service;
        
        const service_name = document.createElement('P');
        service_name.classList.add('service-name');
        service_name.textContent = name;

        const service_price = document.createElement('P');
        service_price.classList.add('service-price');
        service_price.textContent = `$${price}`;

        const service_div = document.createElement('DIV');
        service_div.classList.add('service');
        service_div.dataset.serviceId = id;
        service_div.onclick = function() {
            selectService(service);
        }

        service_div.appendChild(service_name);
        service_div.appendChild(service_price);

        document.querySelector('#services').appendChild(service_div);

    })
}

function selectProduct(product) {
    const {id} = product;
    const {products} = reservation;

    //Producto al que se le dió click
    const product_div = document.querySelector(`[data-product-id="${id}"]`);

    //Comprobar si un product ya fue agregado
    if(products.some(added => added.id === id)){
        //Eliminar el producto
        reservation.products = products.filter(added => added.id !== id);
        product_div.classList.remove('selected');
    } else {
        //Agregar el producto
        reservation.products = [...products, product];
        product_div.classList.add('selected');
    }
}

function selectService(service) {
    const {id} = service;
    const {services} = reservation;

    //Servicio al que se le dió click
    const service_div = document.querySelector(`[data-service-id="${id}"]`);

    //Comprobar si un servicio ya fue agregado
    if(services.some(added => added.id === id)){
        //Eliminar el servicio
        reservation.services = services.filter(added => added.id !== id);
        service_div.classList.remove('selected');
    } else {
        //Agregar el servicio
        reservation.services = [...services, service];
        service_div.classList.add('selected');
    }
}

function saveClientId() {
    reservation.id = document.querySelector('#id').value;
}

function saveClienName() {
    reservation.name = document.querySelector('#name').value;
}

function saveDate() {
    const date = document.querySelector('#date');
    date.addEventListener('input', function(e){
        const day = new Date(e.target.value).getUTCDay();

        if([1].includes(day)) {
            e.target.value = '';
            showAlert('Los lunes no hay servicio', 'error', '.form');
        } else {
            reservation.date = e.target.value;
        }
    });
}

function saveTime() {
    const time = document.querySelector('#time');
    time.addEventListener('input', function(e) {
        const res_time = e.target.value;
        const time_pick = res_time.split(':')[0];
        if(time_pick < 12 || time_pick > 21) {
            e.target.value = '';
            showAlert('No hay servicio a esa hora', 'error', '.form');
        } else {
            reservation.time = e.target.value;
        }
    })
}

function showAlert(message, type, element, hide = true) {
    const prev_alert = document.querySelector('.alert')
    if(prev_alert) {
        prev_alert.remove();
    }

    const alert = document.createElement('DIV');
    alert.textContent = message;
    alert.classList.add('alert');
    alert.classList.add(type);

    const form = document.querySelector(element);
    form.appendChild(alert);

    if(hide){
        setTimeout(() => {
            alert.remove();
        }, 3000);
    }
}

function showSummary() {
    const summary = document.querySelector('.content-sum');

    //Limpiar las alertas
    while (summary.firstChild) {
        summary.removeChild(summary.firstChild);
    }

    if(Object.values(reservation).includes('') || reservation.services.length === 0){
        showAlert('Debes agregar mínimo un servicio y/o llenar todos los datos', 'error', '#step-4', false);
    } else {
        //Heading para servicios
        const info_heading = document.createElement('H3');
        info_heading.textContent = 'Información de la reservación';

        summary.appendChild(info_heading);

        //Formatear el div de resumen
        const {name, date, time, services, products} = reservation;

        const client_name = document.createElement('P');
        client_name.innerHTML = `<span>Nombre:</span> ${name}`;

        //Formatear fecha en español
        const date_obj = new Date(date);
        const month = date_obj.getUTCMonth();
        const day = date_obj.getDate() + 2;
        const year = date_obj.getFullYear();

        const dateUTC = new Date(Date.UTC(year, month, day));

        const options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
        const format_date = dateUTC.toLocaleDateString('es-MX', options);

        const res_date = document.createElement('P');
        res_date.innerHTML = `<span>Fecha:</span> ${format_date}`;

        const res_time = document.createElement('P');
        res_time.innerHTML = `<span>Hora:</span> ${time}`;

        summary.appendChild(client_name);
        summary.appendChild(res_date);
        summary.appendChild(res_time);

        //Heading para servicios
        const service_heading = document.createElement('H3');
        service_heading.textContent = 'Servicios seleccionados';
        summary.appendChild(service_heading);

        services.forEach(service => {
            const {id, name, price, description} = service;

            const service_container = document.createElement('DIV');
            service_container.classList.add('service-container');

            const text_service = document.createElement('P');
            text_service.textContent = name; 

            const price_service = document.createElement('P');
            price_service.innerHTML = `<span>Precio:</span> $${price}`;

            service_container.appendChild(text_service);
            service_container.appendChild(price_service);

            summary.appendChild(service_container);
        });

        //Heading para los productos
        const product_heading = document.createElement('H3');
        product_heading.textContent = 'Productos extra agregados';
        summary.appendChild(product_heading);

        products.forEach(product => {
            const {id, name, price, description, image} = product;

            const product_container = document.createElement('DIV');
            product_container.classList.add('product-container');

            const text_product = document.createElement('P');
            text_product.textContent = name; 

            const price_product = document.createElement('P');
            price_product.innerHTML = `<span>Precio:</span> $${price}`;

            product_container.appendChild(text_product);
            product_container.appendChild(price_product);

            summary.appendChild(product_container);
        });

        //Botón para la reservación
        const container_button = document.createElement('DIV');
        container_button.classList.add('container-submit');

        const res_button = document.createElement('BUTTON');
        res_button.classList.add('boton');
        res_button.textContent = 'Reservar';
        res_button.onclick = doReservation;

        container_button.appendChild(res_button);
        summary.appendChild(container_button);
    }
}

async function doReservation() {
    const {id, date, time, services, products} = reservation;

    const services_id = services.map(service => service.id);
    const products_id = products.map(product => product.id);

    const data = new FormData();

    data.append('userId', id);
    data.append('date', date);
    data.append('time', time);
    data.append('services', services_id);
    data.append('products', products_id);

    //console.log([...data]);

    try {
        //Petiicón hacia la API
        const url = 'http://localhost:3000/api/reservations';

        const response = await fetch(url, {
        method: 'POST',
        body: data
        });

        const result = await response.json();

        if(result.result) {
            Swal.fire({
                icon: 'success',
                title: 'Reservación creada',
                text: 'Has reservado una cita en La barbería ©',
          }).then(() => {
              window.location.reload();
          }) 
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Hubo un error',
            text: 'No se pudo hacer la reservación',
          })
    }   
}