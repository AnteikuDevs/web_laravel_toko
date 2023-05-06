// jquery cookie
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?a(require("jquery")):a(jQuery)}(function(a){function b(a){return h.raw?a:encodeURIComponent(a)}function c(a){return h.raw?a:decodeURIComponent(a)}function d(a){return b(h.json?JSON.stringify(a):String(a))}function e(a){0===a.indexOf('"')&&(a=a.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\"));try{return a=decodeURIComponent(a.replace(g," ")),h.json?JSON.parse(a):a}catch(b){}}function f(b,c){var d=h.raw?b:e(b);return a.isFunction(c)?c(d):d}var g=/\+/g,h=a.cookie=function(e,g,i){if(void 0!==g&&!a.isFunction(g)){if(i=a.extend({},h.defaults,i),"number"==typeof i.expires){var j=i.expires,k=i.expires=new Date;k.setTime(+k+864e5*j)}return document.cookie=[b(e),"=",d(g),i.expires?"; expires="+i.expires.toUTCString():"",i.path?"; path="+i.path:"",i.domain?"; domain="+i.domain:"",i.secure?"; secure":""].join("")}for(var l=e?void 0:{},m=document.cookie?document.cookie.split("; "):[],n=0,o=m.length;o>n;n++){var p=m[n].split("="),q=c(p.shift()),r=p.join("=");if(e&&e===q){l=f(r,g);break}e||void 0===(r=f(r))||(l[q]=r)}return l};h.defaults={},a.removeCookie=function(b,c){return void 0===a.cookie(b)?!1:(a.cookie(b,"",a.extend({},c,{expires:-1})),!a.cookie(b))}});
    
let __advanced = window.ENV

// url
function url(endpoint = '') {

    var props = endpoint.split('//'),
        base = '',
        protocols = __advanced.URL;
    if (props[0] == location.protocol) {
        return endpoint
    } else {

        let urlBases = endpoint.split('/')

        if (urlBases[0] == '') {
            base = protocols + endpoint
        } else {
            base = protocols + '/' + endpoint
        }
        return base
    }
}

function real_url() {
    var current = current_url(),
        src = window.location.search;
    return url(current + src)
}

function current_url(prefix = '') {
    var origin = window.location.origin,
        pathname = window.location.pathname,
        current_url = origin + pathname;
    current_url = current_url.replace(url(), ''), base = '';
    base = url(current_url);
    if (prefix) {
        base = url(current_url) + '/' + prefix;
    }
    return base;
}

function redirect(endpoint = '', blank = false) {
    var props = endpoint.split('://'),
        base = '';
    if ((props[0] == 'http') || (props[0] == 'https')) {
        base = endpoint
    } else {
        base = url(endpoint)
    }

    if (blank) {
        window.open(base, '_blank')
    } else {
        window.location = base
    }
}

function param(param, defaultValue = '') {
    var vars = {};
    var uri = window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
        vars[key] = value
    });
    return vars[param] ? vars[param] : defaultValue;
}

function paramFromUrl(param, url = '', defaultValue = '') {
    var vars = {};
    if (url == '') {
        window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
            vars[key] = value
        });
    } else {
        url.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
            vars[key] = value
        });
    }
    return vars[param] ? vars[param] : defaultValue;
}

function segment(index) {
    var uri_path = current_url().replace(url() + '/', '').split("/")[index - 1];
    uri_path = uri_path ? uri_path : '';
    return decodeURIComponent(uri_path);
}

function param_replace(paramName, paramValue) {
    var urlP = real_url();
    if (paramValue == null) {
        paramValue = '';
    }
    var pattern = new RegExp('\\b(' + paramName + '=).*?(&|#|$)');
    if (urlP.search(pattern) >= 0) {
        return urlP.replace(pattern, '$1' + paramValue + '$2');
    }
    urlP = urlP.replace(/[?#]$/, '');
    var bases = urlP + (urlP.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue;
    return bases
}

function router_push(urlEndpoint = '') {
    window.history.pushState(url(urlEndpoint), "", url(urlEndpoint))
    $(document).trigger('router-changed')
}

function api_url(endpoint = '') {
    return __advanced.API_URL + endpoint
}
// url
// convert type data
var convertType = function (value) {
    var v = Number(value);
    return !isNaN(v) ? v : value === "undefined" ? undefined : value === "null" ? null : value === "true" ? true : value === "false" ? false : value
};
// end convert type data
// element scrolling
function scrollElement(selector) {
    var el = $('body');
    if ($(selector).length) {
        el = $(selector)
    }
    $('html, body').animate({
        scrollTop: el.offset().top - 90
    }, 1000);
}
// end element scrolling
// object to query
function objectToParams(data) {
    return '?' + Object.entries(data).map(e => e.join('=')).join('&');
}

const isObject = (obj) => {
    return Object.prototype.toString.call(obj) === '[object Object]';
};

// end object to query
// cookiee
function set_cookie(key, value) {
    return $.cookie(key, value, {
        path: '/'
    });
}

function get_cookie(key) {
    return $.cookie(key);
}

function remove_cookie(key) {
    return $.removeCookie(key, {
        path: '/'
    });
}
// endcookie
// sessionStorage
function set_session(key, value) {
    sessionStorage.setItem(key, JSON.stringify(value));
}

function get_session(key) {
    if (convertType(sessionStorage.getItem(key))) {
        return JSON.parse(sessionStorage.getItem(key))
    }
}

function remove_session(key) {
    if (Array.isArray(key)) {
        for (var i = 0; i < key.length; i++) {
            sessionStorage.removeItem(key[i])
        }
    } else {
        sessionStorage.removeItem(key)
    }
}
// end sessionStorage

function setUserSigned(value) {
    return set_cookie('uid', value)
}

function log(...arguments) {
    console.log('%clog:',`padding: 2px 5px;
    border-radius: 4px;
    color: #FF5900; background-color: #f6f8fd; font-weight: bold`,...arguments)
}
// custom randomString
function randId(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}
// end custom randomString
// generate api url
function generate_url_response(value) {
    let u = value.split('/')
    if (u[0] == '') {
        return api_url(value)
    } else {
        return api_url('/' + value)
    }

}
// end generate api url

let HttpHeaders = {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
}

if (get_cookie('uid')) {
    HttpHeaders = {
        ...HttpHeaders,
        'Authorization': "Bearer " + get_cookie('uid')
    }
}
let Http = new class {
    get(endpoint, data = null) {
        return new Promise((resolve, reject) => {
            let new_url = data ? generate_url_response(endpoint) + objectToParams(data) : generate_url_response(endpoint)
            fetch(new_url, {
                    method: 'GET',
                    headers: HttpHeaders
                })
                .then(res => res.json())
                .then(function (response) {
                    resolve(response)
                })
                .catch(function (error) {
                    reject(error)
                })
        })
    }
    post(endpoint, data = null) {
        return new Promise((resolve, reject) => {
            fetch(generate_url_response(endpoint), {
                    method: 'POST',
                    headers: HttpHeaders,
                    body: (data ? JSON.stringify(data) : null)
                })
                .then(res => res.json())
                .then(function (response) {
                    resolve(response)
                })
                .catch(function (error) {
                    reject(error)
                })
        })
    }
    put(endpoint, data = null) {
        return new Promise((resolve, reject) => {
            fetch(generate_url_response(endpoint), {
                    method: 'PUT',
                    headers: HttpHeaders,
                    body: (data ? JSON.stringify(data) : null)
                })
                .then(res => res.json())
                .then(function (response) {
                    resolve(response)
                })
                .catch(function (error) {
                    reject(error)
                })
        })
    }
    delete(endpoint, data = null) {
        return new Promise((resolve, reject) => {
            fetch(generate_url_response(endpoint), {
                    method: 'DELETE',
                    headers: HttpHeaders,
                    body: (data ? JSON.stringify(data) : null)
                })
                .then(res => res.json())
                .then(function (response) {
                    resolve(response)
                })
                .catch(function (error) {
                    reject(error)
                })
        })
    }
    fetch(method,endpoint,data = null){
        let _this = this
        switch (method.toLowerCase()) {
            case 'get':
                return this.get(endpoint,data)
                break;
            case 'post':
                return this.post(endpoint,data)
                break;
            case 'put':
                return this.put(endpoint,data)
                break;
            case 'delete':
                return this.delete(endpoint,data)
                break;
        }
    }
}

function FetchDataTable(arguments)
{
    if(typeof arguments !== 'object')
    {
        alert("Arguments must be object only")
        return false;
    }
    let ajax = arguments.ajax;
    // ajax: {
    // 	url: '',
    // 	method: '',
    // 	data: null
    // }
    // 
    if(!ajax)
    {
        alert("ajax arguments required")
        return false;
    }
    let language_default = {
        decimal: "",
        emptyTable: "Data tidak ditemukan",
        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        infoEmpty: "Menampilkan 0 - 0 dari 0 halaman",
        infoFiltered: "(difilter dari _MAX_ total data)",
        infoPostFix: "",
        thousands: ",",
        lengthMenu: "Menampilkan _MENU_ halaman",
        loadingRecords: "Memuat...",
        processing: "Memuat...",
        search: "Cari: ",
        zeroRecords: "Data tidak ditemukan",
        paginate: {
            first: "First",
            last: "Last",
            next: "Selanjutnnya",
            previous: "Sebelumnya"
            // next: "<i class='fa fa-angle-right' title='Selanjutnya'></i>",
            // previous: "<i class='fa fa-angle-left' title='Sebelumnya'></i>"
        },
    }

    let scrollY = arguments.scrollY?? '-',
    scrollX = (arguments.scrollX == true)? true : false,
    responsive = (arguments.responsive == true)? true : false,
    selector = arguments.selector,
    columns = arguments.columns,
    language = arguments.language? arguments.language : language_default,
    processing = arguments.processing == true? true : false;

    let ajax_options = {
        url: generate_url_response(ajax.url),
        type: ajax.method? ajax.method : "GET",
        headers: HttpHeaders,
        dataSrc: ajax.dataSrc? ajax.dataSrc : 'data',
    }

    if(ajax.data)
    {
        ajax_options = {
            ...ajax_options,
            data: ajax.data
        }
    }

    let options = {
        serverSide: true,
        deferRender: true,
        ajax: ajax_options,
        columns: columns,
        language: language
    }
    if(scrollY !== '-')
    {
        options = {
            ...options,
            scrollY: scrollY
        }
    }
    if(scrollX)
    {
        options = {
            ...options,
            scrollX: scrollX
        }
    }
    if(responsive)
    {
        options = {
            ...options,
            responsive: responsive
        }
    }
    if(processing)
    {
        options = {
            ...options,
            processing: processing
        }
    }
    $(selector).DataTable().destroy();
    $(selector).DataTable(options);
}   

let _notif = function (selector, type, msg, scroll = true) {
    let sl = $(selector)
    if (sl.length) {
        if (msg.length == 0) {
            sl.html('')
            return false
        }
        /*
            <button type="button" class="btn-close-alert" data-bs-dismiss="alert" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="24" height="24" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                    <line x1="18" y1="6" x2="6" y2="18" class="text-${type}"></line>
                    <line x1="6" y1="6" x2="18" y2="18" class="text-${type}"></line>
                </svg>
            </button>
        */
        let closeBtn = '_alert_' + randId(6)
        let content = `
        <div class="alert alert-${type} alert-outline alert-outline-coloured alert-dismissible user-select-none" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
            </div>
            <div class="alert-message">
            ${msg}
            </div>
        </div>`
        sl.html(content)
        scrollElement(sl)
    } else {
        console.log('the "' + selector + '" selector not found!')
        return false;
    }
}

let MyNotif = new class {
    constructor() {
        this.defaultSelector = '#single-session'
        this.run()
    }
    run() {
        let key = get_session('my-notif-id');
        if (key) {
            let data = atob(get_session(key));
            if (data) {
                data = JSON.parse(data)

                var action = ''

                if (data.dismiss == true) {
                    action = `<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`
                }

                var time = data.time

                var _html = `
                    <div class="alert alert-${data.type} alert-outline alert-outline-coloured alert-dismissible user-select-none" role="alert">
                        ${action}
                        <div class="alert-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        </div>
                        <div class="alert-message">
                        ${data.message} ${time > 0? '<span class="counter-down fw-600"></span>' : ''}
                        </div>
                    </div>
                `;
                if (data.selector !== 'default') {
                    if ($(data.selector).length) {
                        $(data.selector).html(_html)
                        if (data.scroll == true) {
                            scrollElement(data.selector)
                        }
                        if (time > 0) {
                            var countdown = setInterval(function () {
                                $(data.selector + ' .counter-down').text(`(${time--}s)`)
                                if (time == -1) {
                                    clearInterval(countdown)
                                    $(data.selector).html('')
                                }
                            }, 1000)
                        }
                        remove_session([
                            'my-notif-id',
                            get_session('my-notif-id')
                        ])
                        return true;
                    }
                } else {
                    if ($(this.defaultSelector).length) {
                        $(this.defaultSelector).html(_html)
                        if (data.scroll == true) {
                            scrollElement(this.defaultSelector)
                        }
                        if (time > 0) {
                            var countdown = setInterval(function () {
                                $(this.defaultSelector + ' .counter-down').text(`(${time--}s)`)
                                if (time == -1) {
                                    clearInterval(countdown)
                                    $(this.defaultSelector).html('')
                                }
                            }, 1000)
                        }
                        remove_session([
                            'my-notif-id',
                            get_session('my-notif-id')
                        ])
                        return true;
                    }
                }
            }
            return false;
        }

    }
    set(p) {
        let cnf = {
            type: p.type?? '',
            url: p.url ? url(p.url) : 'default',
            selector: p.selector ? p.selector : 'default',
            message: p.message?? '',
            dismiss: p.dismiss?? true,
            scroll: p.scroll == true ? true : false,
            time: p.time ? p.time : 0
        }
        let rand = randId(7);
        if (p) {
            set_session('my-notif-id', rand)
            set_session(rand, btoa(JSON.stringify(cnf)))
            return true;
        }
    }
}

function redirectWithNotif(url, config) {
    MyNotif.set(config)
    redirect(url)
}

setInterval(function(){
    
    $('[data-error]').each(function(i,el){
        $(el).addClass('error-message-input')
    })

},500)

function errorShows(selector, errorData) {
    if ((Array.isArray(errorData) || isObject(errorData))) {

        let parentSelector = $(selector)

        $.each(errorData, function(i,err){
            let content = ''
            $.each(err,function(j,key){
                content += `<span>${key}</span>`
            })
            parentSelector.find('[data-error="'+i+'"]').html(content)
        })

    }
}

function errorReset(parentSelector) {
    $(parentSelector).find('[data-error]').html('')
}

function logout() {
    remove_cookie('uid')
    redirect('')
}

$('[data-action="logout"]').each(function (i, el) {
    let that = $(el)
    let itemLogoutIds = randId(9) + '_' + randId(3) + '_' + randId(5)
    that.addClass(itemLogoutIds)
    $(document).on('click', '.' + itemLogoutIds, function (e) {
        e.preventDefault()
        logout()
    })
    that.removeAttr('data-action')
})

function toIdr(number) {
    if (number == null) {
        return 0;
    }
    return (number.toString().replace('.', ',')).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function getFormData(selector){
    let obj = {}
    $(selector).find('[name]').each(function(i, el) {
        let _this = $(el)
        let elType = _this.get(0)
        let val = ''
        if(elType.type == 'checkbox')
        {
            if($(selector).find('[name="'+elType.name+'"]').length > 1)
            {
                let subVal = []
                $(selector).find('[name="'+elType.name+'"]:checked').each(function(j,elSub){
                    subVal.push($(elSub).val())
                })
    
                val = subVal
            }else{
                val = $(selector).find('[name="'+elType.name+'"]').val()
            }
        }else if(elType.type == 'radio')
        {
            let checked = $(selector).find('[name="'+elType.name+'"]:checked')
            if(checked.length)
            {
                val = checked.val()
            }else{
                val = $(selector).find('[name="'+elType.name+'"]').val()
            }
        }else{
            val = _this.val()
        }
        
        obj[_this.attr('name')] = val;
    });
    return obj
}

function resetForm(selector){
    $(selector).find('[name]').each(function(i, el) {
        let _this = $(el)
        let elType = _this.get(0)
        let val = ''
        console.log($(el),elType.type)
        if(elType.type == 'checkbox')
        {
            if($(selector).find('[name="'+elType.name+'"]').length > 0)
            {
                $(selector).find('[name="'+elType.name+'"]:checked').each(function(j,elSub){
                    $(elSub).prop('checked',false)
                })
            }
        }else if(elType.type == 'radio')
        {
            let checked = $(selector).find('[name="'+elType.name+'"]:checked')
            if(checked.length)
            {
                $(selector).find('[name="'+elType.name+'"]:checked').prop('checked',false)
            }
        }else if(elType.type == 'select-one' || elType.type == 'select-multiple')
        {
            _this.val('').trigger('change')
        }else{
            _this.val('')
        }
    });
}

function reload(){
    window.location.reload(true)
}
