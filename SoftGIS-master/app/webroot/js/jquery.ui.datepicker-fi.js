/* Finnish initialisation for the jQuery UI date picker plugin. */
/* Written by Harri Kilpi� (harrikilpio@gmail.com). */
jQuery(function($){
    $.datepicker.regional['fi'] = {
		closeText: <?php __('Sulje'); ?>,
		prevText: <?php __('&laquo;Edellinen'); ?>,
		nextText: <?php __('Seuraava&raquo;'); ?>,
		currentText: <?php __('T&auml;n&auml;&auml;n'); ?>,
        monthNames: [<?php __('Tammikuu'), __('Helmikuu'), __('Maaliskuu'), __('Huhtikuu'), __('Toukokuu'), __('Kes&auml;kuu'),
         __('Hein&auml;kuu'), __('Elokuu'), __('Syyskuu'), __('Lokakuu'), __('Marraskuu'), __('Joulukuu'); ?>],
        monthNamesShort: [<?php __('Tammi'), __('Helmi'), __('Maalis'), __('Huhti'), __('Touko'), __('Kes&auml;'),
         __('Hein&auml;'), __('Elo'), __('Syys'), __('Loka'), __('Marras'), __('Joulu'); ?>],
		dayNamesShort: [<?php __('Su'), __('Ma'), __('Ti'), __('Ke'), __('To'), __('Pe'), __('Su'); ?>],
		dayNames: [<?php __('Sunnuntai'), __('Maanantai'), __('Tiistai'), __('Keskiviikko'), __('Torstai'), __('Perjantai'), __('Lauantai'); ?>],
		dayNamesMin: [<?php __('Su'), __('Ma'), __('Ti'), __('Ke'), __('To'), __('Pe'), __('La'); ?>],
		weekHeader: <?php __('Vk'); ?>,
        // dateFormat: 'dd.mm.yy',
        dateFormat: 'yy-mm-dd',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['fi']);
});
