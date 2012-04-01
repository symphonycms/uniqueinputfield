String.prototype.slugify = function() {
    str = this;
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();
    
    // remove accents, swap ñ for n, etc
    var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to   = "aaaaeeeeiiiioooouuuunc------";
    for (var i=0, l=from.length ; i<l ; i++) {
      str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }
    
    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
      .replace(/\s+/g, '-') // collapse whitespace and replace by -
      .replace(/-+/g, '-'); // collapse dashes
    
    return str;
}

function checkAvailability(follower, following) {
    followingValue = following.val();

    slug = followingValue.slugify();

    if(slug != follower.val()) {
        follower.data('refuse', 'true');
    } else {
        follower.data('refuse', 'false');
    }
}

jQuery(function() {
    jQuery('input[follow]').each(function() {
        element = jQuery(this);
        following = element.attr("follow");
        followingElement = jQuery("input[name='fields[" + following + "]']");
        followingElement.attr("follower", element.attr("name"));

        checkAvailability(element, followingElement);

        jQuery(element).keyup(function() {
            checkAvailability(element, followingElement);
        });
        
        jQuery(followingElement).keyup(function() {
            theElement = jQuery("input[name='"+jQuery(this).attr("follower")+"']");
            if(theElement.data("refuse") == 'true') return;

            value = jQuery(this).val();
            theElement.val(value.slugify());
        });
    });
})