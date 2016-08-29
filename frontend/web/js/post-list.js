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
    this.post_cards = [];
    this.$post_list_area = null;
    this.permit_retrieve_post = true;
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
    
    this.$post_list_area = this.$root.find('.post-list-area');
};

PostList.prototype.initEvents = function() {
    $(window).scroll({self:this}, this.retrievePostWhenScroll_);
};

PostList.prototype.retrievePostWhenScroll_ = function(e) {
    var self = e.data.self;
    var scrollPercentage = 
            ((document.documentElement.scrollTop + document.body.scrollTop) / 
            (document.documentElement.scrollHeight - document.documentElement.clientHeight) * 100);
    if(scrollPercentage > PostList.prototype.SCROLL_VALUE) {
        if(self.permit_retrieve_post) {
            self.permit_retrieve_post = false;
            $.ajax({
                url: $("#base-url").val() + "/site/get-more-posts",
                type: 'post',
                data: {'ids' : self.stuff_ids, query: self.query, location: self.location},
                success: function(data) {
                    var parsedData = JSON.parse(data);
                    if(parsedData['status'] === 1) {
                        self.$post_list_area.append(parsedData['view']);
                        $(parsedData['view']).filter('.post-card').each(function(index, value) {
                            self.post_cards.push(new PostCard($(value)));
                            self.stuff_ids += "," + $(value).data('stuff_id');
                        });
                    }
                    self.permit_retrieve_post = true;
                },
                error : function(data) {
                    self.permit_retrieve_post = true;
                    
                }
            });   
        }
    }

};

PostList.prototype.searchNewData  = function(query, location) {
    this.query = query;
    this.location = location;
    
    $.ajax({
        url: $("#base-url").val() + "/site/get-more-posts",
        type: 'post',
        context: this,
        data: {'ids' : this.stuff_ids, query: this.query, location: this.location},
        success: function(data) {
            var parsedData = JSON.parse(data);
            if(parsedData['status'] === 1) {
                this.$post_list_area.html(parsedData['view']);
                this.post_cards = [];
                this.stuff_ids = "0";
                $(parsedData['view']).filter('.post-card').each(function(index, value) {
                    var post_card = new PostCard($(value));
                    this.post_cards.push(post_card);
                    post_card.initEvents();
                    this.stuff_ids += "," + $(value).data('stuff_id');
                });
            }
            this.permit_retrieve_post = true;
        },
        error : function(data) {
            this.permit_retrieve_post = true;

        }
    });
};