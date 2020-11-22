

    //-----------------------------------------------------
    // Фиксированный заголовок у таблицы
    //-----------------------------------------------------
    // by ManHunter / PCL (www.manhunter.ru)
    //-----------------------------------------------------
    fix_header={
      'fixed_el': null,
      'new_table': null,
     
      bind : function(el, eventName, callback) {
        if (el) {
          if (el.addEventListener) {
            el.addEventListener(eventName, callback, false);
          }
          else if (el.attachEvent) {
            el.attachEvent("on" + eventName, callback);
          }
        }
      },
     
      get_position: function(el) {
        var offsetLeft = 0, offsetTop = 0;
        do {
          offsetLeft += el.offsetLeft;
          offsetTop  += el.offsetTop;
        }
        while (el = el.offsetParent);
        return {x:offsetLeft, y:offsetTop};
      },
     
      chk_position: function() {
        var doc = document.documentElement;
        var body = document.body;
     
        if (typeof(window.innerWidth) == 'number') {
          my_width = window.innerWidth;
          my_height = window.innerHeight;
        }
        else if (doc && (doc.clientWidth || doc.clientHeight)) {
          my_width = doc.clientWidth;
          my_height = doc.clientHeight;
        }
        else if (body && (body.clientWidth || body.clientHeight)) {
          my_width = body.clientWidth;
          my_height = body.clientHeight;
        }
     
        if (doc.scrollTop) { dy=doc.scrollTop; } else { dy=body.scrollTop; }
     
        var coord=fix_header.get_position(fix_header.fixed_el);
     
        // Заголовок таблицы еще на экране или таблица уже не на экране
        if (coord.y>dy || (coord.y+fix_header.fixed_el.clientHeight)<dy) {
          fix_header.new_table.style.left='-9999px';
        }
        // Заголовок уже прокручен вверх
        else {
          fix_header.new_table.style.left=
            fix_header.fixed_el.getBoundingClientRect().left+'px';
        }
      },
     
      fix: function (id) {
        var tmp,st;
        var ftable=document.getElementById(id);
        if (ftable) {
          if (this.new_table!=null) {
            if (this.new_table.parentNode!=undefined) {
              this.new_table.parentNode.removeChild(this.new_table);
            }
            this.new_table=null;
          }
          else {
            this.bind(window,'scroll',this.chk_position);
            this.bind(window,'resize',this.chk_position);
          }
     
          this.fixed_el=ftable;
     
          tmp=ftable.getElementsByTagName('thead');
          if (tmp) {
            var fthead=tmp[0];
     
            new_table=document.createElement('table');
     
            for(var i in this.fixed_el.style) {
              if (this.fixed_el.style[i]!='') {
                try {
                  new_table.style[i]=this.fixed_el.style[i];
                }
                catch (e) {};
              }
            }
     
            new_table.id='fixed_'+id;
            new_table.rules='all';
           // new_table.style='tr {border:0}';
           // new_table.style.border='1px solid #fafafa';
            //new_table.style='padding:21px 25px 22px 25px';
            new_table.style.fontFamily="Arial";
            new_table.style.fontSize='13px';
            new_table.style.color='#666';
            new_table.style.textShadow='1px 1px 0px #fff';
            //new_table.style.margin='30px';
            //new_table.border='#ccc 1px solid';
            new_table.borderCollapse='collapse';
            //new_table.borderSpacing='-20px';
            //new_table.style.textAlign='left';
            //new_table.border='0';
            
            //new_table.style='height:50px';
            new_table.style.position='fixed';
           // new_table.style.left='-9999px';
            new_table.style.top='0px';
            new_table.style.background='#fff';
     
            var cln = fthead.cloneNode(true);
            var cth=cln.getElementsByTagName('th');
            var fth=fthead.getElementsByTagName('th');
     
            for(var i=0; i<fth.length; i++) {
              cth[i].style.width=(fth[i].clientWidth+(window.opera?1:0))+'px';
              cth[i].style.paddingLeft='0';
              cth[i].style.paddingRight='0';
            }
            new_table.appendChild(cln);
     
            this.fixed_el.parentNode.appendChild(new_table);
            this.new_table=new_table;
            this.chk_position();
          }
        }
      }
    };

