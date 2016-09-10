/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var PostList = function($root) {
    this.$root = $root;
    this.stuff_ids = '';
    this.id = $root.data('id');
    this.location = $root.data('location');
    this.query = '';
    this.tags =[];
    this.post_cards = [];
    this.$post_list_area = null;
    this.permit_retrieve_post = true;

    //loading
    this.$new_loading = null;
    this.new_loading = null;
    this.$get_more_loading = null;
    this.get_more_loading = null;
    
    this.$reached_the_end = null;
    //retrieving
    this.is_retrieving = false;
    
    this.init();
    this.initEvents();
};


PostList.prototype.SCROLL_VALUE = 95;

PostList.prototype.init = function() {
    $.each($(".post-card"), function(index, value) {
        this.post_cards.push(new PostCard($(value))); 
        if(this.stuff_ids === '' ) {
            this.stuff_ids += $(value).data('stuff_id');
        } else {
            this.stuff_ids += "," + $(value).data('stuff_id');   
        }
    }.bind(this));
    
    this.$new_loading = this.$root.find('#' + this.id + "-new-loading");
    this.new_loading = new Loading(this.$new_loading);
    this.$get_more_loading = this.$root.find('#' + this.id + "-get-more-loading");
    this.get_more_loading = new Loading(this.$get_more_loading);
    this.$post_list_area = this.$root.find('.post-list-area');
    this.$reached_the_end = this.$root.find('.post-list-no-more');
};

PostList.prototype.initEvents = function() {
  
};

PostList.prototype.getHeight = function() {
    return this.$root.height();

};

PostList.prototype.setNewTags = function(tags ) {
    this.tags = tags;
    
    this.searchNewData();
    this.is_retrieving = false;
    
    this.$reached_the_end.addClass('hide');

};

PostList.prototype.setQueryAndLocation = function(query, location) {
    this.query = query;
    this.location = location;
    
    setTimeout(this.searchNewData.bind(this), 300);
    this.is_retrieving = false;
    this.$reached_the_end.addClass('hide');
}

PostList.prototype.stringifyArray = function(items) {
    var stringify = '';
    var first = true;
    for(var i = 0; i < items.length; i++) {
        if(first) {
            stringify += items[i];
            first  = false;
        } else {
            stringify += "," + items[i];
        }
    }
    
    return stringify;
}

PostList.prototype.searchNewData  = function() {
    this.new_loading.show();
    $.ajax({
        url: $("#base-url").val() + "/site/search-new-data",
        type: 'post',
        context: this,
        data: {query: this.query, location: this.location, tags : this.stringifyArray(this.tags)},
        success: function(data) {
            var parsedData = JSON.parse(data);
            if(parsedData['status'] === 1) {
                this.$post_list_area.html(parsedData['view']);
                this.post_cards = [];
                this.stuff_ids = "0";
                $(parsedData['view']).filter('.post-card').each(function(index, value) {
                    var post_card = new PostCard($(value));
                    this.post_cards.push(post_card);
                    this.stuff_ids += "," + $(value).data('stuff_id');
                }.bind(this));
            }
            this.new_loading.hide();
        },
        error : function(data) {
            this.new_loading.hide();
        }
    });
};

PostList.prototype.getMorePosts  = function() {
    if(!this.is_retrieving) {
        this.get_more_loading.show();

        this.is_retrieving = true;
        $.ajax({
            url: $("#base-url").val() + "/site/get-more-posts",
            type: 'post',
            context: this,
            data: {query: this.query, ids: this.stuff_ids, location: this.location, tags : this.stringifyArray(this.tags)},
            success: function(data) {
                this.is_retrieving = false;
                var parsedData = JSON.parse(data);
                if(parsedData['status'] === 1) {
                    this.$post_list_area.append(parsedData['view']);
                    if(parsedData['view'] === '') {
                        this.is_retrieving = true;
                        this.$reached_the_end.removeClass('hide');
                    }
                    $(parsedData['view']).filter('.post-card').each(function(index, value) {
                        var post_card = new PostCard($(value));
                        this.post_cards.push(post_card);
                        this.stuff_ids += "," + $(value).data('stuff_id');
                    }.bind(this));
                }
                this.get_more_loading.hide();
            },
            error : function(data) {
                this.is_retrieving = false;
                this.get_more_loading.hide();
            }
        });
    }
};
