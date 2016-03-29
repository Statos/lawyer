/*
 * SIMP
 */

/* OPEN PAGE!!! */
function PageOpen(card) {
    $('#infosys-title').text(card.title);
    //$('#infosys-page').fadeIn(400);
	//Проверка на повторное открытие
	if (card.id==last_open)
	{
		if (card.itype == 1 && false) return 0;
		if (card.itype != 1 && true) return 0;
		console.log(card.id+' - '+last_open);
	}
    
    if (card.itype == 1) 
	{ //Внешняя ссылка
		$('#infosys-page div.page-close').click();

        $(".desc", "#infosys-desc").html('desc');

        //$('#site-infosys').fadeOut(500).css('background-image','url(/template/front/img/info-bg.png)').fadeIn(500);
        //$('#infosys-page-site').fadeOut(0);
        //$('#infosys-page-site div.header').html(card.title);
        //$('#infosys-page-site div.content').html('<br />');
        //
        //$('#infosys-page-site div.content').append('<IFRAME style="margin-left:50px;" id="remote_site" height="100%" align="left">Сайт ' + card.title + '</iframe>');
        //$('#remote_site').attr('src', card.url);
        //$('#remote_site').load(function () {
        //    //$(this)
        //    //$('#r_site').niceScroll("#rh_site",{boxzoom:true});
			////var w=$('#infosys-page-site div.content').width();
			////alert(w);
			////$('#remote_site').css('width',(w-55)+'px');
        //});
        //
        //$('#site-infosys').css('background-image', 'url(/template/front/img/info-bg.png)');
        //$('#simp').fadeOut(500);
        //$('#infosys-page-site').fadeIn(500);
        //
        //last_open=card.id;

        SiteInfosysPageClose();
    }
    else 
	{
		$('#infosys-page div.wrap').fadeOut(200);
        $('#infosys-page').html(' ').attr('id', 'inf-mn');
		$('#inf-mn').children('').remove();
		$('#inf-mn').html('<div class="bg">123</div>');
        $('#inf-mn').show();

        $('#site-data').load(card.url, function () {
            $('#inf-mn').html('<div class="bg">'+$('#infosys-page').html()+'</div>');
            $('#site-data').html(' ');
            $('#inf-mn').attr('id', 'infosys-page');

            $('#infosys-page').show();
			$('#infosys-page div.wrap').fadeOut(0);
			$('#infosys-page div.wrap').fadeIn(200);
            
            $('#inf_1').fadeIn(0);

            $('#infosys-txt').niceScroll({
                cursorcolor: "#808080",
                cursoropacitymin: 0.3,
                background: "#fff",
                cursorborder: "0",
                cursorwidth: "9",
                cursorborderradius: "0",
                autohidemode: false,
                horizrailenabled: false,
                cursorminheight: 30
            });
            SiteInfosysTabs();
			last_open=card.id;
            SiteInfosysPageClose();

        });
    }
}


/* ПЕРЕМЕННЫЕ */
var YR = {
    settings: {
        site: {
            jsp_settings: {
                verticalGutter: 0,
                verticalDragMinHeight: 45
            },
            duration: 1000
        }
    }

};

var last_open=0;
var page_open = 0;
var tree_panel;
var Tree = [];
var Elements = {};
var $Elements = {
};
var ResizeArr = [];
var Data = {
    start_focus: 0,
	id_focus:0,
    brick_size: 153,
    focused: false,
    active_cont: false,
    animating: false
};

var Irush = {};
Irush.KEYS = {
    ENTER: 13,
    ESCAPE: 27,
    LEFT_ARROW: 37,
    UP_ARROW: 38,
    RIGHT_ARROW: 39,
    DOWN_ARROW: 40,
    NUM_2: 50,
    NUM_4: 52,
    NUM_6: 54,
    NUM_8: 56,
    NUMPAD_2: 98,
    NUMPAD_4: 100,
    NUMPAD_6: 102,
    NUMPAD_8: 104
};

Irush.MOUSE_BUTTONS = {
    UNKNOWN: 0,
    LEFT: 1,
    RIGHT: 3,
    MIDDLE: 2
};

Irush.Direction = {
    UP: '-',
    DOWN: '+',
    LEFT: '-',
    RIGHT: '+',
    HORIZONTAL: '1',
    VERTICALE: '2'
}


/* ГРАБЛИ IE )) */
function getClientWidth() {
    return document.compatMode == 'CSS1Compat' && !window.opera ? document.documentElement.clientWidth : document.body.clientWidth;
}

function getClientHeight() {
    return document.compatMode == 'CSS1Compat' && !window.opera ? document.documentElement.clientHeight : document.body.clientHeight;
}


/* ФУНКЦИИ */

function simp_init() //ЗАПУСК СИМП
{
    var $simp = $('#simp');
    tree_panel = $('#tree-panel', $simp);
    $Elements.wrap = $('.wrap', $simp);
    var iH = $simp.height();
//    ResizeArr.push({
//        f: f
//    });
//    function f() {
//
//        var cwleft, wleft, cwwidth = 710;
//        var iW = $simp.width();
//        if (iW * 0.7 < cwwidth + Data.brick_size + 5) {
//            cwleft = iW - 640;
//            wleft = cwleft - Data.brick_size - 5;
//        } else {
//            cwleft = iW * 0.3 + 152;
//            wleft = iW * 0.3;
//        }
//        $Elements.wrap.css({
//            left: wleft
//        });
//    }
//
//    f();
//
//    $(window).resize(function () {
//        for (var i in ResizeArr) {
//            i = ResizeArr[i];
//            if (i && i.f && typeof(i.f) == 'function')
//                if (i.scope)
//                    i.f.call(i.scope);
//                else
//                    i.f();
//        }
//    });
    get_tree();
    bind_events();
	
	$('#simp').click(function(e){
		//LOGO CLICK
		var current=Elements[Data.focused];
		if (current.parent!=0)
		{
			brick_click(e,current.parent.id);
			current=current.parent;
			brick_click(e,Data.id_focus);
		}
		//console.log(current);
		//brick_click(e,Data.id_focus);
	});
}


/* ФУНКЦИИ ДАННЫХ */
function mytree() {

    var obj_img = {
        "album": 0,
        "allow_dislikes": 0,
        "comments": "",
        "date": "2013-07-26 15:52:06",
        "description": "",
        "dislikes": "",
        "dislikes_count": 0,
        "filename": "img/1.jpg",
        "height": 413,
        "id": 105,
        "likes": "",
        "likes_count": 0,
        "sizes": "",
        "tag_ids": "",
        "user_id": 2,
        "width": 550
    };
    var obj_item = {
        "base": 1,
        "blocked": 0,
        "children": "",
        "description": "Описание элемента",
        "id": 1,
        "img": "",
        "last_update": "2013-10-10 07:57:45",
        "leaf": false,
        "likes": "",
        "parent": 0,
        "private": 0,
        "title": "Кино",
        "url": "",
        "itype": 2
    };
    //SET LEVELS
    $('#simp-tree ul').addClass('u1');
    $('#simp-tree ul ul').removeClass('u1').addClass('u2');
    $('#simp-tree ul ul ul').removeClass('u1').removeClass('u2').addClass('u3');
    $('#simp-tree ul ul ul ul').removeClass('u1').removeClass('u2').removeClass('u3').addClass('u4');

    $('#simp-tree ul.u1 li').addClass('l1');
    $('#simp-tree ul.u1 ul.u2 li').removeClass('l1').addClass('l2');
    $('#simp-tree ul.u1 ul.u2 ul.u3 li').removeClass('l1').removeClass('l2').addClass('l3');
    $('#simp-tree ul.u1 ul.u2 ul.u3 ul.u4 li').removeClass('l1').removeClass('l2').removeClass('l3').addClass('l4');

    var root = [];
    var id = 1;
    //LEVEL 1
    $('ul.u1 li.l1').each(function (index, element) {
        var img = clone(obj_img);
        img.filename = $(this).children('span').children('img').attr('src');
        img.id = 1000 + id;
        var itm = clone(obj_item);
        itm.id = $(this).children('span').children('p.id').text();
        itm.title = $(this).children('span').children('p.title').text();
        itm.description = $(this).children('span').children('p.description').text();
        itm.intro_img = $(this).children('span').children('p.intro-img').text();
        itm.itype = $(this).children('span').children('p.itype').text();
        itm.img = img;

        //LEVEL 2
        var pid = id;
        var l2 = [];
        $(this).find('ul.u2 li.l2').each(function (index, element) {
            id++;
            var itm2 = clone(obj_item);
            var url_a = $(this).children('span').children('a');
            if (url_a.length > 0) {
                itm2.leaf = true;
                itm2.url = $(url_a).attr('href');
            }
            var img2 = clone(obj_img);
            img2.filename = $(this).children('span').children('img').attr('src');
            img2.id = 1000 + id;

            itm2.id = $(this).children('span').children('p.id').text();
            itm2.parent = pid;
            itm2.title = $(this).children('span').children('p.title').text();
            itm2.description = $(this).children('span').children('p.description').html(); // HTML FIX HERE
            itm2.intro_img = $(this).children('span').children('p.intro-img').text();
            itm2.itype = $(this).children('span').children('p.itype').text();
            itm2.img = img2;

            //LEVEL3
            var l3 = [];
            var pid2 = id;
            $(this).find('ul.u3 li.l3').each(function (index, element) {
                id++;
                var itm3 = clone(obj_item);
                var url_a = $(this).children('span').children('a');
                if (url_a.length > 0) {
                    itm3.leaf = true;
                    itm3.url = $(url_a).attr('href');
                }
                var img3 = clone(obj_img);
                img3.filename = $(this).children('span').children('img').attr('src');
                img3.id = 1000 + id;

                itm3.id = $(this).children('span').children('p.id').text();
                //itm3.leaf=true;
                itm3.base = 0;
                itm3.parent = pid2;
                itm3.title = $(this).children('span').children('p.title').text();
                itm3.description = $(this).children('span').children('p.description').text();
                itm3.intro_img = $(this).children('span').children('p.intro-img').text();
                itm3.itype = $(this).children('span').children('p.itype').text();
                itm3.img = img3;

                l3.push(itm3);
            });

            itm2.children = l3;
            l2.push(itm2);
        });

        itm.children = l2;


        root.push(itm);
        id++;
    });
    return root;
}


function get_tree() {
    Tree = mytree(); // получить дерево
    get_elements();
    show_tree();
    show_mini_tree();
}

function get_elements() {
    Elements = {};
    for (var i in Tree) {
        i = Tree[i];
        Elements[i.id] = i;
        for (var j in i.children) {
            j = i.children[j];
            j.category = j.parent = i;
            Elements[j.id] = j;
            for (var k in j.children) {
                k = j.children[k];
                k.category = i;
                k.theme = k.parent = j;
                Elements[k.id] = k;
            }
        }
    }
}

/* ФУНКЦИИ УПРАВЛЕНИЯ */

function brick_click(e, id) {
    cancelEvent(e);
    var el = $(e.target || e.srcElement),
        card = Elements[id],
        attr = Elements[id].id;
    if (Elements[id].itype == 2) {
        $("#infosys-desc").stop().animate({opacity: 0}, 500);
        $(".title", "#infosys-desc").html(Elements[id].title);
        $(".desc", "#infosys-desc").html(Elements[id].description);
        $(".cover", "#infosys-desc").css('background-image', 'url("'+Elements[id].intro_img+'")');
        brick_click.locked++;
        if (brick_click.locked == 1) {
            setTimeout(function () {
                $(".brick[nid=" + attr + "]").trigger("click");
                brick_click.locked = 0
            }, 500);
        }
    } else {
        $('#infosys-page').fadeOut(500, function () {
            $('#infosys-txt').getNiceScroll().remove();
        });
        $("#infosys-desc").stop().animate({opacity: 1}, 500);
        $(".title", "#infosys-desc").html(Elements[id].title);
        $(".desc", "#infosys-desc").html(Elements[id].description);
        $(".cover", "#infosys-desc").css('background-image', 'url("'+Elements[id].intro_img+'")');
        
    }

    if (el.hasClass('open')) {
        //URL CLICK
        //alert('Open '+card.url); //CLICK
        //PageOpen(card);
        return false;
    }
    var me = Elements[id], focused = Elements[Data.focused];
    if (id != Data.focused && me) {
        if (me.visible) {
            if (me.parent == focused.parent || me == focused.parent || me.parent == focused)
                focus_brick(id);
            else {
                focus_brick(focused.parent.id);
                focus_brick(id);
            }
        } else if (focused.parent) {
            focus_brick(focused.parent.id);
            focus_brick(id);
        }
    }
    else {
        if (card.leaf) {
            //alert('Open '+card.title);
            PageOpen(card);
        }
    }
    return false;
}
brick_click.locked = 0;

function bind_events() { //УСТАНОВКА СОБЫТИЙ (КНОПКИ + СКРОЛЛ)
    $(document).keydown(function (event) {
        //if( $.is($("div:animated"))) break; // блокировка от новых событий если есть анимация
        if (false == false && true == false) {
            var is_move = false, dir;
            switch (event.which) {
                case Irush.KEYS.LEFT_ARROW  :
                    dir = 'left';
                    is_move = true;
                    break;
                case Irush.KEYS.RIGHT_ARROW :
                    dir = 'right';
                    is_move = true;
                    break;
                case Irush.KEYS.UP_ARROW   :
                    dir = 'up';
                    is_move = true;
                    break;
                case Irush.KEYS.DOWN_ARROW :
                    dir = 'down';
                    is_move = true;
                    break;
                case Irush.KEYS.ENTER :
                    //open_card(Data.focused);
                    var card = Data.focused;
                    card = card.id ? card : Elements[card];
                    if (card.leaf) {
                        	PageOpen(card);
                        //alert('Open '+card.title);
                    }
                    //alert('open2');

                    break;
                case Irush.KEYS.ESCAPE:
                    var me = Elements[Data.focused];
                    if (me.parent.id)
                        focus_brick(me.parent.id);
                    else
                        focus_brick(Tree[Data.start_focus].id);
                    break;
            }
            if (is_move) {
                cancelEvent(event);
                move(dir);
            }
        }
        else {
            switch (event.which) {
                case Irush.KEYS.ESCAPE:
                    if (false)
                        $('#infosys-page-site div.page-close').click();
                    if (true)
                        $('#infosys-page div.page-close').click();
                    break;
            }
        }
    });
    tree_panel.mousewheel(function (e, d, dx, dy) {
        //if (false == false && true == false) {
		if (false == false) {
            //cancelEvent(e);
			//alert(dy);
            move(dy > 0 ? 'up' : 'down');
            return;
            switch (true) {
                case Data.active_cont.dir && dy > 0:
                    move('up');
                    break;
                case Data.active_cont.dir && dy < 0:
                    move('down');
                    break;
                case !Data.active_cont.dir && dx > 0:
                    move('left');
                    break;
                case !Data.active_cont.dir && dx < 0:
                    move('right');
                    break;
            }
        }
    });
}


/* ФУНКЦИИ ДВИЖЕНИЯ */
function set_coord(cont, n) {
    var d = cont.dir ? 'top' : 'left', css = {};
    css[d] = -Data.brick_size * (n + (cont.is_root ? 0 : 1));
    cont.$move.stop(cont.queue, true).queue(cont.queue, function () {
        $(this).animate(css, {
            duration: 500,
            easing: 'swing',
            queue: false
        });
    });
    cont.$move.dequeue(cont.queue);
}

function move(dir) {
    var d = 1, out = false, next;
    var current = Elements[Data.focused];
    var cont = current.self_cont;
    var attr = Elements[Data.focused];
    switch (dir) {
        case 'up':
        case 'down':
            out = !cont.dir;
            break;
        case 'left':
        case 'right':
            out = cont.dir;
            break;
        default:
            return false;
    }
    if (dir == 'up' || dir == 'left') {
        if (out && !current.leaf)return;
        d = -1;
    }
    if (out) {
        if (current.leaf) {
            cont = current.parent.self_cont;
            next = cont.active;
            focus_brick(cont.elements[next].id);
            move(dir);
            return;
        } else {
            cont = current.child_cont;
            next = 0;
        }
    } else {
        next = current.n + d;
        if (next == cont.count || next == -1 && cont.is_root || next == -2)
            return;
        if (next == -1) {
            cont = current.parent.self_cont;
            next = cont.active;
        }
    }

    next = cont.elements[next];
    if (next.itype == 2 || next.itype == 1) {
        $("#infosys-desc").stop().animate({opacity: 0}, 500);
        $(".title", "#infosys-desc").html(next.title);
        $(".desc", "#infosys-desc").html(next.description);
        $(".cover", "#infosys-desc").css('background-image', 'url("'+next.intro_img+'")');
        brick_click.locked++;
        if (brick_click.locked == 1) {
			//$(".brick[nid=" + next.id + "]").trigger("click");
                //brick_click.locked = 0;
			//x1
			
			
            setTimeout(function () {
				if (next.id==Data.focused)
				{
					$(".brick[nid=" + next.id + "]").trigger("click");
					brick_click.locked = 0;
					console.log("yes");
				}
				else
				{
					$(".brick[nid=" + Data.focused + "]").trigger("click");
					brick_click.locked = 0;
					console.log("no");
				}
            }, 500);
        }
    } else {
        $('#infosys-page').fadeOut(500, function () {
            $('#infosys-txt').getNiceScroll().remove();
        });
        $("#infosys-desc").stop().animate({opacity: 1}, 500);
        $(".title", "#infosys-desc").html(next.title);
        $(".desc", "#infosys-desc").html(next.description);
        $(".cover", "#infosys-desc").css('background-image', 'url("'+next.intro_img+'")');
    }
    focus_brick(next.id);
}

function get_minitree_height(elm) {
    r = elm.css('height');
    h = elm.css('height', 'auto').height();
    elm.css('height', r);
    return h;
}

function focus_minitree(id) {
    tree = $('.simpmenu', window.parent.document);
    focus_elm = tree.find('[rel=' + id + ']');
    if (!focus_elm.length) {
        return false;
    }
    if (focus_elm.hasClass('simptree_subitem')) {
        tree.find('.simptree_subitem.active').removeClass('active');
        focus_elm.addClass('active');
        return false;
    }

    focus_blk = focus_elm.next();

    blur_elm = tree.find('.simptree_item.active');
    if (blur_elm.length) {
        blur_blk = blur_elm.next();
        blur_elm.removeClass('active');
        blur_blk.stop().animate({height: 0}, 500);
        blur_blk.each(function () {
            $(this).removeClass('active')
        });
    }

    tree.find('.simptree_subitem.active').removeClass('active');

    focus_elm.addClass('active');
    focus_blk.stop().animate({height: get_minitree_height(focus_blk)}, 500);

    return false;
    f = true;


    $('.simptree_item', window.parent.document).each(function () {
        var self = $(this);
        b = self.next();
        if (self.attr('rel') == id) {
            self.addClass('active');
            h = b.css('height', 'auto').height();
            b.css('height', 0);
            b.addClass('active').stop().animate({height: h}, 350);
            f = false;
        } else {
            self.removeClass('active');
            b.removeClass('active').stop().animate({height: 0}, 1000);
        }
    });
    if (!f) {
        return false;
    }
    $('.simptree_subitem', window.parent.document).each(function () {
        var self = $(this);
        b = self.parent();
        if (self.attr('rel') == id) {
            self.addClass('active');
            h = b.css('height', 'auto').height();
            b.css('height', 0);
            b.addClass('active').stop().animate({height: h}, 350);
        } else {
            self.removeClass('active');
            b.removeClass('active').stop().animate({height: 0}, 1000);
        }
    });
}

function focus_brick(id) {
    focus_minitree(id);
    var next = Elements[id];
    var fh = true, fs = true;//hide(fh) and show(fs) children(true) or nearest(false)
    if (Data.focused) {
        var current = Elements[Data.focused];
        if (next.self_cont == current.child_cont)
            fh = false;
        if (current.self_cont == next.child_cont) {
            fs = false;
            current.self_cont.$.removeClass('active');
        }
        blur_brick(Data.focused, fh, !next.leaf);
    }
    Data.focused = id;
    Data.active_cont = next.self_cont;
    next.self_cont.active = next.n;
    next.self_cont.$.addClass('active');
    next.$.addClass('focused active');
    set_coord(next.self_cont, next.n);
    if (!fs)
        set_coord(current.self_cont, -1);
    if (!next.leaf)
        show_elements(id, fs);
}


/* ФУНКЦИИ ПОКАЗА */
function show_mini_tree() {
    e = $('.simpmenu', window.parent.document);
    for (var i = 0; i < Tree.length; i++) {
        a = $('<div rel="' + Tree[i].id + '" class="simptree_item" onclick="window.parent.frames[0].brick_click(event, ' + Tree[i].id + ')"/>').html(Tree[i].title).appendTo(e);
        d = $('<div class="simptree_block"/>').appendTo(e);
        $('<div style="margin-top:23px;">').appendTo(e);
        for (var k = 0; k < Tree[i].children.length; k++) {
            c = Tree[i].children[k];
            a = $('<div rel="' + c.id + '" class="simptree_subitem" onclick="window.parent.frames[0].brick_click(event, ' + c.id + ')"/>').html(c.title).appendTo(d);
        }
    }
}

function show_tree() {
    var res = '', n = -1, size = Data.brick_size, focused = false, tmp;//вынести определение размера в функцию инициализации
    tree_panel.html('');
    Data.focused = false;
    var cont1 = {
        count: Tree.length, //count of children
        $: tree_panel, //jQuery-object on page
        $move: tree_panel, //jQuery-object on page to move
        active: -1, //number of active child
        dir: true, //true - vertical, false - horizontal
        is_root: true,
        elements: Tree,
        queue: 'fx1'
    };
    for (var i in Tree) {
        i = Tree[i];
        i.n = ++n;
        i.self_cont = cont1;//parent container
        tmp = document.createElement('div');
        tmp.innerHTML = f(i);
        i.$ = $(tmp.firstChild).css('top', n * size);
        i.$img = $('>.cont>.img', i.$);
        i.visible = true;
        i.child_cont = {
            $: $('.children', i.$), //jQuery-object on page
            $move: tree_panel, //i.$.children('.cont'), //object to move
            count: i.children.length, //count of children
            active: -1, //number of active child
            dir: false, //true - vertical, false - horizontal
            is_root: false,
            elements: i.children,
            queue: 'fx2'
        };
        if (Data.start_focus == n) {
            i.$.addClass('focused');
            focused = i.id;
			//xxx
			Data.id_focus=i.id;
        }
        var jn = -1;
        for (var j in i.children) {
            j = i.children[j];
            j.self_cont = i.child_cont;//parent container
            j.n = ++jn;
            tmp = document.createElement('div');
            tmp.innerHTML = f(j);
            j.$ = $(tmp.firstChild);
            j.$img = $('>.cont>.img', j.$);
            j.visible = false;
            j.$.css('left', -size);
            j.child_cont = {
                $: $('.children', j.$), //jQuery-object on page
                $move: j.$.children('.cont'), //object to move
                count: j.children.length, //count of children
                active: -1, //number of active child
                dir: true, //true - vertical, false - horizontal
                is_root: false,
                elements: j.children,
                queue: 'fx3'
            };
            var kn = -1;
            for (var k in j.children) {
                k = j.children[k];
                k.self_cont = j.child_cont;//parent container
                k.n = ++kn;
                tmp = document.createElement('div');
                tmp.innerHTML = f(k);
                k.$ = $(tmp.firstChild);
                k.$img = $('>.cont>.img', k.$);
                k.visible = false;
                k.$.css('top', -size);
                j.child_cont.$.append(k.$);
            }
            i.child_cont.$.append(j.$);
        }
        tree_panel.append(i.$);
    }
    focus_brick(focused || Tree[0].id);

    function f(a) {
        bgimg_style = (a.img && a.img.filename) ? 'url(' + a.img.filename + ')' : 'none';
        return '<div class="brick ' + (a.self_cont.dir ? 'ver' : 'hor') + '" n="' + a.n + '" nid="' + a.id + '" onclick="brick_click(event,' + a.id + ')">\
			<div class="cont">\
			' + (a.leaf ? '<div class="open"></div>' : '') + '<div class="cnt"></div>\
			<div class="img" style="background-image: ' + bgimg_style + ';background-color:' + rand_color() + '">\
			<div class="title" title="' + a.title + '"><span>' + a.title + '</span></div></div>' +
            (a.children.length ? '<div class="children"></div>' : '') +
            '</div></div>';
    }
}

function blur_brick(id, f, hide) {
    if (!id)return;
    var me = Elements[id];
    me.$.removeClass('focused' + (f ? ' active' : ''));
    if (hide)
        hide_elements(id, f);
}

function show_elements(id, children) {
    var me = Elements[id];
    var css = {}, cont, d = me.self_cont.dir == children ? 'left' : 'top';
    if (children) {
        cont = me.children;
    } else {
        cont = me.self_cont.elements;
    }
    for (var i in cont) {
        i = cont[i];
        css[d] = Data.brick_size * i.n;
        i.$.stop().animate(css, {
            duration: 500,
            easing: 'swing'
        });
        i.$img.stop().animate({
            opacity: 1//0.5
        }, {
            duration: 500,
            easing: 'swing'
        });
        i.visible = true;
    }
}

function hide_elements(id, children) {
    var me = Elements[id];
    var d = me.self_cont.dir == children ? 'left' : 'top';
    var css = {}, cont;
    if (children) {
        css[d] = -Data.brick_size;
        cont = me.children;
    } else {
        css[d] = Data.brick_size * me.n;
        cont = me.self_cont.elements;
    }
    for (var i in cont) {
        i = cont[i];
        if (i.id == id)continue;
        i.$.stop().animate(css, {
            duration: 500,
            easing: 'swing'
        });
        i.$img.stop().animate({
            opacity: 0
        }, {
            duration: 500,
            easing: 'swing'
        });
        i.visible = false;
    }
}


/* ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ */
function clone(o) {
    return eval("(" + JSON.stringify(o) + ")");
} // КЛОНИРОВАНИЕ ОБЪЕКТА

function cancelEvent(e) {
    e = e ? e : window.event;
    if (e.stopPropagation) {
        e.stopPropagation();
    }
    if (e.preventDefault) {
        e.preventDefault();
    }
    e.cancelBubble = true;
    e.cancel = true;
    e.returnValue = false;
    return false;
}

function f_apply(scope, config, reverse) {
    if (reverse) {
        var t = scope;
        scope = config;
        config = t;
    }
    for (var c in config)
        scope[c] = config[c];
    return scope;
}

function rand_color() {
    var colors = ['FFFF00', '996600', 'FF6600', 'CC0000', 'CC3366', '9900CC', '6633FF', '000066', '00CCFF', '339933', '66FF00', 'CCFF33'];
    return '#' + colors[Math.floor(Math.random() * colors.length)];
}

function find_in_tree(id) {
    for (var i in Tree) {
        i = Tree[i];
        if (i.id == id)
            return i;
        for (var j in i.children) {
            j = i.children[j];
            if (j.id == id)
                return j;
            for (var k in j.children) {
                k = j.children[k];
                if (k.id == id)
                    return k;
            }
        }
    }
}

function SiteInfosysTabs() {
    zoom();
    $('#infosys-pathway ul li a').click(function () {
        if (!$(this).parent().hasClass('active')) {
            var x = $(this).attr('class').split(' ');
            x = x[0].split('_');
            x = x[1];
            var i = 0;
            $('#infosys-pathway ul li').removeClass('active');
            $(this).parent().addClass('active');
            for (i = 1; i < 7; i++) {
                if (i != x)
                    $('#inf_' + i).fadeOut(100, function () {
                        if (x != 3) {
                            if ($('#comment_type_chosen').hasClass('set')) {
                                $('#comment_type_chosen').removeClass('set');
                                $('#comment_type_chosen').chosenDestroy();
                                $('#comments div.scroll').getNiceScroll().remove();

                            }
                        }
                    });
                else
                    $('#inf_' + i).fadeIn(100, function () {
                        if (x == 3 && !$('#comment_type_chosen').hasClass('set')) {
                            //CommentsInit();
                            $('#comments div.scroll').niceScroll({
                                cursorcolor: "#808080",
                                cursoropacitymin: 0.3,
                                background: "#fff",
                                cursorborder: "0",
                                cursorwidth: "9",
                                cursorborderradius: "0",
                                autohidemode: false,
                                horizrailenabled: false,
                                cursorminheight: 30
                            });
                            //SiteCommentsAdd();
                            $('#comment-type').addClass('set');
                            $('#comment-attachments').addClass('set');
                            //CommentsFilter();
                        }
                    });
            }
        }
    });
}

function SiteInfosysPageClose() {

    $('#infosys-page-site div.page-close').click(function () {
        $('#infosys-page-site').fadeOut(500);
        $('#simp').fadeIn(500);
        $('#site-infosys').css('background-image', 'none');
    });

    $('#infosys-page div.page-close').click(function () {
        brick_click.locked = 0;
        $('#infosys-page').fadeOut(500, function () {
            $('#infosys-txt').getNiceScroll().remove();
        });
    });
}

function zoom() {
    //$("a.zoom").fancybox({
    //    'transitionIn': 'elastic',
    //    'transitionOut': 'elastic',
    //    'showNavArrows': true,
    //    'cyclic': true,
    //    'titlePosition': 'over',
    //    'hideOnOverlayClick': true,
    //    'hideOnContentClick': true,
    //    'overlayShow': true,
    //    'overlayColor': '#111'
    //});
}