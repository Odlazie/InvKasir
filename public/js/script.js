const link = window.location;
const BASE_URL = $('#base-url').data('url');

/* tambahkan class active pada menu yang dipilih tanpa class nav-treeview */
$("ul.nav-sidebar a").filter(function () {
    return this.href == link;
}).addClass("active");
/* tambahkan class menu-open pada menu yang dipilih yang ada class nav-treeview */
$("ul.nav-treeview a").filter(function () {
    return this.href == link;
}).parentsUntil(".nav-sidebar > .nav-treeview").addClass("menu-open").prev("a").addClass("active");
// buat animasi loading web
$(".preloader").fadeOut();