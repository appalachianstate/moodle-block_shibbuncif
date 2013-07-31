// This file is part of Moodle - http://moodle.org/

M.block_shibbuncif = {

    Y: null, transaction: [],

    submit: function() {

        YUI().use('cookie', function(Y) {
            var frm = document.forms['shibbuncif']; var ddlist = frm.elements['idp'];
            if (ddlist.selectedIndex < 1)
            	return;
            var cookievalue = btoa(ddlist.value);
        	Y.Cookie.set('_saml_idp', cookievalue, { 
        		path: frm.elements['cookiepath'].value,
        		expires: new Date(Date.now() + (100 * 24 * 3600000)),
        		raw: true });
            window.location.href = frm.elements['sessinit'].value + ddlist.value;
    	});

    },

    init: function(Y) {

        this.Y = Y;

        Y.one('form[name="shibbuncif"]').set('onsubmit', function() { return false; });
        Y.one('form[name="shibbuncif"] input[type="submit"]').set('onclick', M.block_shibbuncif.submit);

    },

};
