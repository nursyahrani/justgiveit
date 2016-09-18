var Profile = function($root) {
    this.$root = $root;
    this.give_list = null;
    this.profile_section = null;
    this.profile_bio = null;
    this.init();
};

Profile.prototype.SCROLL_VALUE = 85;
Profile.prototype.init = function() {
    this.give_list = new ProfilePostList(this.$root.find('#profile-post-list-gives'));
    this.profile_section = new ProfileSection(this.$root.find('#profile-section'));
    this.profile_bio = new ProfileBio(this.$root.find('#profile-bio'));
    $(".main-view").scroll(function(e) {
        var scrollPercentage = 
                100 * $(".main-view").scrollTop() / ($(".main-view")[0].scrollHeight - $(".main-view").height());
        console.log(scrollPercentage);
        if(scrollPercentage > this.SCROLL_VALUE) {
            this.give_list.getMorePosts();
        }
    }.bind(this));
}