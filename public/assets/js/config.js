var baseUrl;

if (typeof APP_ENV !== 'undefined' && APP_ENV === 'local') {
    baseUrl = "/";
} else {
    baseUrl = "/pelaporan-hilir/";
}

export { baseUrl };
