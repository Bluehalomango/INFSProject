<section id = 'search_title'>
    <form id = 'search_menu'>
        <h1 class = 'title'> Game Library: <h1>
        <section class = 'options'>
        <?php echo form_open('ajax', 'autocomplete=off'); ?>
            <div class = "autocomplete" id = "parent">
                <input class="form-control mr-sm-2" type="search" id="search_form" placeholder="Search for Games" name="search" aria-label="Search" autocomplete="off">
            </div>
        <?php echo form_close(); ?>
            <label for="filters">Filter By:</label>
            <select name="filters" id="filters">
                <option value="name">Name</option>
                <option value="dor">Date of Release</option>
                <option value="popularity">Popularity</option>
            </select>

            <label for="order">Order by:</label>
            <select name="order" id="order">
                <option value="ASC">Ascending</option>
                <option value="DESC">Descending</option>
            </select>
        </section>
    </form>
</section>

<section id = "suggestions">
</section>
<section id = "search_results">
</section>

<script>
$(document).ready(function(){
    parse_filter();
    var currentFocus;
    document.getElementById("order").onchange = function() {parse_filter()};  
    document.getElementById("filters").onchange = function() {parse_filter()};  
    document.getElementById("parent").onchange = function() {parse_filter()};  

        function load_data(query1, filter, order){
            var query = filter + "." + order + "." + query1;
            $.ajax({
            url:"<?php echo base_url(); ?>ajax/search",
            method:"GET",
            data:{search:query, te:filter, order:order},
            success:function(response){
                $('#search_results').html("");
                if (response == "" ) {
                    $('#search_results').html(response);
                } else {
                    var obj = JSON.parse(response);
                    var flex = [];
                    if(obj.length>0){
                        flex = [];
                        $.each(obj, function(i,val){
                            var name = val.name;
                            var dor = val.dor;
                            var year = dor.split('-', 1);
                            var description = val.description;
                            var filename = val.filename;
                            var id = val.game_id;
                            var title = "<article class = 'flex-item'> <h1 class = 'name'> " + name + ', ' + year + "</h1>";
                            var description = "<h1 class = 'descript'>" + description + "</h1> </article>";
                            var image = "<article class = 'flex-item1'> <img class = 'poster' src=" + '<?php echo base_url(); ?>/uploads/' + filename + " /> </article>";
                            var content = "<section class = 'wrapper' onclick=load_game(" + id + ")>" + image + title + description + "</section>";
                            flex.push($(content));
                        });
                        $('#search_results').append.apply($('#search_results'), flex);         
                    }else{
                    $('#search_results').html("<h2> No games were found for that search </h2>");
                    }; 
                };
            }
        });
        }

        function autocomplete(query1, filter, order){
            while (document.getElementsByClassName("name1").length > 0) {
                clear_autocomplete();
            }
            a = document.createElement("div");
            a.setAttribute("id", "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            $('.autocomplete').append(a);
            var query = filter + "." + order + "." + query1;
            $.ajax({
            url:"<?php echo base_url(); ?>ajax/autocomplete",
            method:"GET",
            data:{search:query, te:filter, order:order},
            success:function(response){
                $('#autocomplete').html("");
                if (response == "" ) {
                    $('#autocomplete').html(response);
                } else { 
                    var obj = JSON.parse(response);
                    var flex = [];
                    if(obj.length>0){
                        flex = [];
                        $.each(obj, function(i,val){
                            var name = val.name;
                            var title = "<h1 class = 'name1' value = '" + name + "'> " + name +  "</h1>";
                            flex.push($(title));
                            if (check_list(name)) {
                            b = document.createElement("div");
                            var att = document.createAttribute("value");      
                            att.value = name;                         
                            b.setAttributeNode(att);    
                            b.onclick = function(){ set_search(this.getAttribute("value")); };
                            b.innerHTML = title;
                            b.innerHTML += "<input type='hidden' value='" + name + "'>";
                            a.append(b);
                            }
                        });     
                    }else{
                    $('#autocomplete').html("Not Found!");
                    }; 
                };
            }
        });       
        }

        $(window).click(function() {
            clear_autocomplete();
        });

        $('#autocomplete-list').click(function(event){
            event.stopPropagation();
        });

        function set_search(search) {
            document.getElementById("search_form").value = search;
            parse_filter();
        }

        function check_list(val) {
            var list = document.getElementsByClassName("name1");
            for (var i = 0; i < list.length; i++) {
                if (list[i].getAttribute("value") == val) {
                    return false;
                }
            }
            return true;
        }

        function clear_autocomplete() {
            var list = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < list.length; i++) {
                list[i].remove();
            }
            return true;
        }

        function parse_filter() {
            var search = $(search_form).val();
            var filter = $(filters).val();
            var sort_order = $(order).val();
            load_data(search, filter, sort_order);
            if (search != '') {
                autocomplete(search, filter, sort_order);
            }
        }

        $('#search_form').keyup(function(){
            parse_filter();
        });
    });
</script>

<style>

* {
	margin: 0;
	padding: 0;
}

.autocomplete {
  position: relative;
  display: inline-block;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff;
  border-bottom: 1px solid #d4d4d4;
}

.autocomplete-items div:hover {
  background-color: #e9e9e9;
}


#search_menu {
    display: flex;
    flex-wrap: nowrap;
    justify-content: center;
    align-items: center;
}

.title {
    font-size: 3em;
    padding: 20px;
}

.options {
    font-size:0.8em;
}

#search_results {
    width: 80vw;
    border-style: solid;
    margin:auto;
    border-color: black;
}

.discussion > * {
    margin-top: 10px;
}

.poster {
    max-width: 25vw;
    max-height: 25vw;
}

.discussion {
    display: flex;  
    flex-flow: row nowrap;
    margin: 20px;
    border-color: black;
    border-style: solid;
}

.flex_aside {
    width: 70%;
    padding: 10px;
    line-height: 150px;
}

.views_aside {
    width: 30%;
    padding: 20px;
    line-height: 150px;
    text-align: right;
}

.topic {
    font-size: 2em;
}

.subtext {
    font-size: 1em;
}

.wrap {
    background: purple;
    width: 90vw;
    margin: 5%;
}

.aside {

}

</style>