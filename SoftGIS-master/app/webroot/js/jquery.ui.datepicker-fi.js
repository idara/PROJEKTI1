// http://openflights.org/blog/2009/05/29/dynamic-javascript-localization-with-gettext-and-php/
var gt = new Gettext({ 'domain' : 'messages' });

/* Finnish initialisation for the jQuery UI date picker plugin. */
/* Written by Harri Kilpi� (harrikilpio@gmail.com). */
jQuery(function($){
    $.datepicker.regional['fi'] = {
		closeText: gt.gettext('Sulje'),
		prevText: '&laquo;' + gt.gettext('Edellinen'),
		nextText: gt.gettext('Seuraava') + '&raquo;',
		currentText: gt.gettext('T&auml;n&auml;&auml;n'),
        monthNames: [gt.gettext('Tammikuu'),gt.gettext('Helmikuu'),gt.gettext('Maaliskuu'),gt.gettext('Huhtikuu'),gt.gettext('Toukokuu'),gt.gettext('Kes&auml;kuu'),
        gt.gettext('Hein&auml;kuu'),gt.gettext('Elokuu'),gt.gettext('Syyskuu'),gt.gettext('Lokakuu'),gt.gettext('Marraskuu'),gt.gettext('Joulukuu')],
        monthNamesShort: [gt.gettext('Tammi'),gt.gettext('Helmi'),gt.gettext('Maalis'),gt.gettext('Huhti'),gt.gettext('Touko'),gt.gettext('Kes&auml;'),
        gt.gettext('Hein&auml;'),gt.gettext('Elo'),gt.gettext('Syys'),gt.gettext('Loka'),gt.gettext('Marras'),gt.gettext('Joulu')],
		dayNamesShort: [gt.gettext('Su'),gt.gettext('Ma'),gt.gettext('Ti'),gt.gettext('Ke'),gt.gettext('To'),gt.gettext('Pe'),gt.gettext('Su')],
		dayNames: [gt.gettext('Sunnuntai'),gt.gettext('Maanantai'),gt.gettext('Tiistai'),gt.gettext('Keskiviikko'),gt.gettext('Torstai'),gt.gettext('Perjantai'),gt.gettext('Lauantai')],
		dayNamesMin: [gt.gettext('Su'),gt.gettext('Ma'),gt.gettext('Ti'),gt.gettext('Ke'),gt.gettext('To'),gt.gettext('Pe'),gt.gettext('La')],
		weekHeader: gt.gettext('Vk'),
        // dateFormat: 'dd.mm.yy',
        dateFormat: 'yy-mm-dd',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['fi']);
});
