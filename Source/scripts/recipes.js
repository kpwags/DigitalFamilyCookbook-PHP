function gotoSection(sectionName) {
    $('.section').hide();
    $('#' + sectionName).fadeIn(1000);
    $('.menu ul li').removeClass('active');
    $('#' + sectionName + '-item').addClass('active');
}