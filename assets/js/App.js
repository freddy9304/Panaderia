var uHtml = {
  /**
   * //http://bootsnipp.com/tags
  * Drag para elementos HTML con jquery
  *
  * @param item
  * @param callback
  */
  drag: function(item, callback) {
    $(item).mousedown(function(e) {
      this._iDrag = true;
      callback && callback('start', e.pageX, e.pageY);
    });
    $(item).mouseout(function(e) {
      this._iDrag = false;
      callback && callback('stop', e.pageX, e.pageY);
    });
    $(item).mouseup(function(e) {
      this._iDrag = false;
      callback && callback('stop', e.pageX, e.pageY);
    });
    $(item).mousemove(function(e) {
      if (this._iDrag) {
        callback && callback('drag', e.pageX, e.pageY);
      }
    });
  },
  previewComponent: function(type_, file_, title_, version_) {
    var pathTmp_ = toth.path;
    pathTmp_ = pathTmp_.replace(/src/, '');
    pathTmp_ = pathTmp_.replace(/\//, '');
    pathTmp_ += '?build=Animation&preview=true&type=' + type_ + '&item=' + file_ + '&version='
      + version_ + (title_ ? '&title=' + title_ : '');
    var posX = (screen.width / 2) - ((screen.width - 250) / 2);
    var posY = (screen.height / 2) - ((screen.height - 200) / 2);
    window.open(pathTmp_, "Preview Alebrigma [" + file_ + "]", "width="
      + (screen.width - 250) + "," + "height=" + (screen.height - 250) + ","
      + "menubar=0," + "toolbar=0," + "directories=0," + "location=0,"
      + "scrollbars=no," + "resizable=no," + "left=" + posX + "," + "top="
      + posY);
    return true;
  },

  /**
   * Agrega un elemento html
   * addHtml('div','id:idDiv|class:demo-container','Texto del div');
   */
  addHtml: function(type, pp, value) {
    var st = '', r;
    if (pp) {
      var rr = pp.split('|');
      for (var x = 0; x < rr.length; x++) {
        r = rr[x].split(':');
        r[1] != 'undefined' && (st += ' ' + (r[0] == '!' ? r[1] : (r[0] + '="' + r[1] + '"')));
      }
    }
    return '<' + type + st + '>' + (value || '') + '</' + type + '>';
  },
  /**
   * Agrega un elemento Html
   * addElement('input',['id','name','value'],'id|name|value');
   */
  addElement: function(type, dt, vt, data) {
    var rr = vt.split('|');
    var st = '', rr;
    if (dt) {
      for (var x = 0; x < dt.length; x++)
        dt[x] != undefined && (st += ' ' + (rr[x] == '!' ? dt[x] : (rr[x] + '="' + dt[x] + '"')));
    }
    return '<' + type + ' ' + st + (data ? '>' + data + '</' + type + '>' : '/>');
  },
  /**
   * Convierte un array a un HTML
   */
  createHtml: function(data, bb) {
    var ht = '',
      ot = '', d, r, rr, ty, cls, lt, rq;
    //console.log(data);
    for (var idx = 0; idx < data.length; idx++) {
      d = data[idx];
      ty = 0;
      rq = undefined;
      ot = '';
      cls = 'form-group';
      //console.log(d[0]);
      if (typeof d == 'string') {
        if (d == '-')
          ht += '<hr/>';
        else
          ht += d;
      } else {
        /\+$/.test(d[0]) && (ty = 1, d[0] = d[0].replace('+', '')); //clase bloque
        /\-$/.test(d[0]) && (ty = 2, d[0] = d[0].replace('-', '')); //clase inline
        /^\!/.test(d[1]) && (rq = 'required', d[1] = d[1].replace('!', '')); //requiere
        switch (d[0]) {
          case 'hidden':
            d[3] = d[2] + '';d[2] = null;
          case 'file':
          case 'password':
          case 'number':
          case 'url':
          case 'tel':
          case 'email':
          case 'color':
          case 'date':
          case 'time':
          case 'datetime':
          case 'range':
          case 'search':
          case 'text':
            d[2] && (ot += uHtml.addElement('label', [d[1]], 'for', d[2]));
            ot += uHtml.addElement('input', [d[0], d[1], d[1], d[3], 'form-control', rq],
              'type|id|name|value|class|!');
            break;
          case 'textarea':
            d[2] && (ot += uHtml.addElement('label', [d[1]], 'for', d[2]));
            ot += uHtml.addHtml('textarea', 'id:' + d[1] + '|name:' + d[1] +
              '|rows:5|class:form-control' + (rq ? '|!:required' : ''), d[3] || '');
            break;
          case 'reset':
          case 'submit':
          case 'button': //
            cls = d[0] == 'submit' ? 'primary' : (d[0] == 'reset' ? 'danger' : 'default');
            ot += uHtml.addHtml('button', 'type:' + d[0] + '|id:' + d[1] + '|name:' + d[1] +
              '|class:btn btn-' + cls + (rq ? '|!:required' : ''), d[2] || '');
            ty = false;
            break;
          case 'select':
            for (var i = 0; i < d[3].length; i++) {
              r = d[3][i].split(':');
              rr = [r[0], d[4] == r[0] ? 'selected' : undefined];
              ot += uHtml.addElement('option', rr, 'value|selected', r[1]);
            }
            ot = uHtml.addElement('select', [d[1], d[1], 'form-control', rq],
              'id|name|class|!', ot);
            d[2] && (ot = uHtml.addElement('label', [d[1]], 'for', d[2]) + ot);
            break;
          case 'radio':
          case 'checkbox':
            cls = 'checkbox';
            d[2] && (ot += uHtml.addElement('label', [], '', d[2]));
            var chk;
            for (var i = 0; i < d[3].length; i++) {
              r = d[3][i].split(':');
               chk =('|'+d[4]+'|').indexOf('|'+r[0]+'|') !==-1;
              rr = [d[0], d[1] + i, d[1]+'[]', r[0], chk ? 'checked' : undefined];
              lt = uHtml.addElement('input', rr, 'type|id|name|value|checked');
              lt = uHtml.addHtml('label', ty == 2 ? 'class:' + d[0] + '-inline' : '', lt + (r[1] || ''));
              ot += (ty == 1 ? uHtml.addHtml('div', 'class:' + d[0], lt) : lt);
            }
            ty = false;
            break;
          case 'check-toggle':
            d[2] && (ot += uHtml.addElement('label', [], '', d[2]));
            lt='';
            lt ='';
            var chk=0;
            for (var i = 0; i < d[3].length; i++) {
              r = d[3][i].split(':');
              chk =('|'+d[4]+'|').indexOf('|'+r[0]+'|') !==-1;
              rr = ['checkbox', d[1] + i, d[1]+'[]', r[0], chk? 'checked' : undefined,'off'];
              cls = uHtml.addElement('input', rr, 'type|id|name|value|checked|autocomplete')+
                    uHtml.addHtml('span', 'class:glyphicon glyphicon-ok', ' ');
              lt += uHtml.addHtml('label','class:btn btn-default'+(chk?' active':''),r[1]+' '+cls);
            }
            ot += uHtml.addElement('div', ['btn-group','buttons'], 'class|data-toggle',lt);
          break;
          case 'uid':
            rr = d[2].split('-');
            var vv = d[3].split('-');
            lt='';
            for(var i in rr ){
              lt += uHtml.addElement('input', ['text','box-uid-item',d[1]+rr[i],d[1]+'['+rr[i]+']',vv[i]||'',rr[i]], 'type|class|id|name|value|placeholder');
            }
            ot +=  uHtml.addElement('div',['box-uid-group'], 'class',lt);
          break;
          case 'agree':
            lt = uHtml.addElement('input', ['checkbox',d[4]||undefined,d[1],d[1],1], 'type|checked|id|name|value')+
                 uHtml.addElement('label', [d[1]], 'for',d[3]);
            ot +=  uHtml.addElement('div', ['checkbox3 checkbox-'+d[2]+' checkbox-inline checkbox-check  checkbox-circle checkbox-light'], 'class',lt);
          break;
          case 'loadbar':
           lt =  uHtml.addElement('div', ['progress-bar progress-bar-'+(d[4]||'')+' progress-bar-striped active','progressbar','100','0','100','width: 100%'], 'class|role|aria-valuenow|aria-valuemin|aria-valuemax|style',d[2]);
           ot += uHtml.addElement('div', [d[1],'progress '+d[3]], 'id|class', lt);
            break;
          case 'alert':
              ot +=  uHtml.addElement('div', ['alert alert-'+d[2],'alert',d[1]], 'class|role|id',d[3]);
            break;
          case 'rangebar':
            ot+= uHtml.addHtml('div','class:range range-primary',
                  uHtml.addHtml('input','class:box-rangebar:|type:range|id:'+d[1]+'|name:'+d[1]+'|min:0|max:100|value:'+d[3]||'0')+
                  uHtml.addHtml('output','id:'+d[1]+'Output',d[3])
                );
          break;
          case 'calendar-datetime':
            ot+=uHtml.createHtml([
                d[2]?['label','',d[2]]:'',
                ['div','class:input-group date box-datetimer|id:'+d[1]+'DatetimerPicker',[
                  ['text',d[1],'',d[3]||''],
                  ['span','class:input-group-addon',[
                    ['span','class:glyphicon glyphicon-calendar']]]
                ]]]);
            break;
          case 'attached':
            lt =  uHtml.addHtml('li', 'class:glyphicon glyphicon-plus', '');
            lt =  uHtml.addHtml('button','data-count:0|type:button|class:aif-btn-file btn btn-default|id:'+d[1] ,lt+' '+d[2]);
            lt =  uHtml.addHtml('h3','class:panel-title' ,lt);
            lt =  uHtml.addHtml('div','clss:cpanel-heading' ,lt)+
                  uHtml.addHtml('ul','class:list-group|id:'+d[1]+'Body' ,'');
            ot += uHtml.addHtml('div', 'class:panel panel-default', lt);
          break;
          case 'img':
            var xx; rr = d[1].split('|'); vv=[];
            lt='src';
            vv.push(d[2]);
            for(var i in rr ){
              xx = rr[i].split(':');
              vv.push(xx[1]);
              lt+='|'+xx[0];
            }
            ot+=uHtml.addElement('img', vv, lt)
          break;

          default: ot += uHtml.addHtml(d[0], d[1],
            typeof d[2]=='object'?uHtml.createHtml(d[2]):d[2]);
        }
        ht += ty ? uHtml.addHtml('div', 'class:' + cls, ot) : ot;
      }
    }
    //console.log('finalize.............' + ht);
    return ht;
  },

 form:function (id,url,data,btn,css,barLabel){
  return '<form id="'+id+'" role="form" data-toggle="validator" novalidate="true" '+(css||'')+'>'+uHtml.createHtml(data)+
      '<div id="idBar'+id+'" class="progress hide">'+
      '<div class="progress-bar progress-bar- progress-bar-striped active"'+
        ' role="progressbar" aria-valuenow="100" aria-valuemin="0"'+
        ' aria-valuemax="100" style="width: 100%">'+
        (barLabel || 'Espere un momento...')+'</div></div>'+
        '<div class="text-right">'+
          '<button id="'+id+'Submit" type="submit" class="btn btn-primary">'+(btn||'Enviar')+'</button>'+
        '</div></form>';
    },

  createForm: function(id, data, pp) {
    pp = pp || 'class:uhtml-form';
    var fr = uHtml.addHtml('form', 'role:form|id:' + id + '|' + pp, uHtml.createHtml(data));
    $('body').html(uHtml.addHtml('div', 'class:container', fr));
    //
  },
  createModal: function(id, title,data,labelBtn,lock,cls,labelBar,type) {
    $('#' + id).remove();
    type || (type=1);
    var hh = '';
    if(labelBtn || (type==2)){
      hh = uHtml.addHtml('span', 'aria-hidden:true', '&times;');
      hh = uHtml.addHtml('button', 'id:' + id + 'BtnCloseTop|type:button|' +
        'class:close|data-dismiss:modal|aria-label:Cerrar', hh);
    }
    hh += uHtml.addHtml('h4', 'class:modal-title', title);
    hh = uHtml.addHtml('div', 'class:modal-header', hh);
    data.push(['loadbar','idBar'+id,labelBar||'','hide']);
    var bb = uHtml.addHtml('div', 'class:modal-body', uHtml.createHtml(data));
    var ff = '';
    if(type==1 || labelBtn=='x'){
        ff=uHtml.addHtml('button', 'id:' + id + 'BtnClose|type:button|' +
          'class:btn btn-default|data-dismiss:modal', 'Cerrar');
      }
    if(labelBtn && labelBtn!='x'){
       ff+= uHtml.addHtml('button', 'id:' + id + 'BtnSave|type:button|' +
          'class:btn btn-primary', labelBtn||'Guardar');
    }
    ff && (ff = uHtml.addHtml('div', 'class:modal-footer', ff));
    var dd = uHtml.addHtml('div', 'class:modal-content', hh + bb + ff);
    dd = uHtml.addHtml('div', 'class:modal-dialog', dd);
    dd = uHtml.addHtml('div', 'id:' + id + '|class:modal '+(cls||''), dd);
    $('body').append(dd);
    var win = $('#' + id);
    win.onCenter = function(){
      win.css({top: '50%',
        transform: 'translateY(-50%)',
      });
      return this;
    };
    win.onLock=function(ty){
      win.modal({ backdrop: ty?'static':'',keyboard: ty?true:false});
      return this;
    };
    win.onClose=function(){
      win.modal('hide');
      win.remove();
      return null;
    };
    win.onLoadBar=function(ty,lck){
      ty ? $('#idBar'+id).removeClass('hide'):$('#idBar'+id).addClass('hide');
      if(lck){
        $("form :input").attr('readonly', 'readonly');
        $(':button').attr("disabled", true);
        //$(":checkbox").attr('readonly', 'readonly');
      }else{
        $("form :input").removeAttr('readonly');
        $(":button").attr("disabled", false);
        //$(":checkbox").removeAttr('readonly');
      }
      return this;
    };
    lock && win.onLock(true);
    win.on('shown.bs.modal', function(e) {
      win.focus();
    });
   return win;
  },
  onLoading: function(id,ty,title) {
    id || (id = 'idLoadingModal');
    var win = $('#'+id);
    win.length && ty && (win.modal('hide'),win.remove(),win=[]);
    win.length || (win = uHtml.createModal(id,title||'',[],null,true));
    if(ty){
      win.modal('show').onLoadBar(true).onCenter();
      return win;
    }
    return win.onClose();
  },
  evtForm:function(){
    var bb = $('.aif-btn-file');
    bb.length && uHtml.onAttached(bb);
    $('.box-rangebar').mousemove(function(event) {
      var id = $(this).attr('id');
      $('#'+id+'Output').val($(this).val());
    });
  },
  addModal: function(id, title, data, callback,labelBtn,lock,ty,wd,hg) {
    if(!uHtml.onSupport())return null;
    var win = uHtml.createModal(id,title,data,labelBtn,lock,'fade modal-primary in','Espere un momento...',ty||1);
    uHtml.evtForm();
    $('#' + id + 'BtnSave').click(function() {
      callback && callback(true);
    });
    $('#' + id + 'BtnClose').click(function() {
      callback && callback(false);
    });
    $('#' + id + 'BtnCloseTop').click(function() {
      callback && callback(false);
    });
    wd && $('.modal-dialog').css('width', wd);
    hg && $('.modal-dialog').css('min-height', hg);

    win.css('margin', '100px auto 100px auto');
    // win.modal('show');

    return win;
  },
  onSupport:function(){
    var sp = true;
    if (window.JSON == undefined)sp=false;
    if (window.FormData==undefined)sp=false;
    if(!sp){
      uHtml.createModal('idModal',' Problemas de compatibilidad',[
       ['alert','idAlert','danger','Lamentablemente tu navegador es incompatible con algunas funcionalidades del la aplicaci&oacute;n, para hacer de &eacute;sta una mejor experiencia, te sugerimos que utilices Google Chrome'
        ],
       '<br/> Si a&uacute;n no lo tienes, puedes descargarlo gratis aqu&iacute;: ',
       '<a href="http://www.google.com/chrome">http://www.google.com/chrome</a>'
      ],'Aceptar',false,'fade modal-primary in','').modal('show');
    }
    return sp;
  },
  addList:function(id,data,imgs){
    var ht ='',img,ar;
    if(data)
      for(x in data){
        img=null;
        if(data[x].indexOf('|')!==-1){
          ar = data[x].split('|');
          data[x]=ar[0];
          img = imgs+ar[1]+'.png';
        }
        ht+='<li id="'+id+x+'" class="list-group-item">'+
        '<a id="_1'+id+x+'" class="pull-left oplistbtn1'+id+'" href="#">'+
         '<span class="glyphicon glyphicon-save"></span>'+
        '</a>&nbsp;&nbsp;'+
        '<a id="_2'+id+x+'" href="#" class="oplistbtn2'+id+'">'+
          (img?'<img class="icon-file" src="'+img+'" />':'')+data[x]
         +'</a>'+
        '<a id="_3'+id+x+'" href="#" class="pull-right oplistbtn3'+id+'">'+
          '<span class="glyphicon glyphicon-trash"></span>'+
        '</a>&nbsp;</li>';
    }
    return ht;
  },
  onAttached:function(itm){
    itm.length && itm.click(function(event) {
      var id = $(this).attr('id');
      var idx = parseInt($(this).attr('data-count'));
      $('#'+id+'Body').append('<li id="aifInputFile'+id+idx+'" class="list-group-item">'+
        uHtml.addElement('input',['file',id+idx,id+idx,'pull-left'],'type|id|name|class','')+
        '<a href="javascript:$(\'#aifInputFile'+id+idx+'\').remove();"><span class="glyphicon glyphicon-remove pull-right"></span></a>&nbsp;'+
        '</li>');
      $(this).attr('data-count',idx+1);
     console.log(id,idx);
    });
  },

  addPages:function(id,nm,ty,active){
    var ht ='';
    for (var i = 1; i<=nm; i++)
      ht+= uHtml.createHtml([['li',(i==active?'class:active|':'')+'id:'+id+'Pg'+i,'<a class="'+id+'Pg" data-pg="'+i+'" href="#">'+i+'</a>']]);
    $('#'+id).html(uHtml.createHtml([
      ty?['li','id:'+id+'PgP','<a class="'+id+'Pg" data-pg="P" href="#"><i class="fa fa-arrow-left"></i></a>']:'',
      ty==2?'':ht,
      ty?['li','id:'+id+'PgN','<a class="'+id+'Pg" data-pg="N" href="#"><i class="fa fa-arrow-right"></i></a>']:''
    ]));
  }
};

var uApp = {
    jsonDecode: function(str) {
    if (str) {
      var json = window.JSON;
      if (typeof json === 'object' && typeof json.parse === 'function') {
        try {
          return json.parse(str);
        } catch (err) {
          if (!(err instanceof SyntaxError)) {
            throw new Error(
              'Unexpected error type in json_decode()');
          }
          return null;
        }
      }
    }
    return null;
  },
  objForm:function(id){
    var win = {};
    win.modal=function() {
      return this;
    };
    win.onLoadBar=function(ty,lck){
      ty ? $('#idBar'+id).removeClass('hide'):$('#idBar'+id).addClass('hide');
      if(lck){
        $("form :input").attr('readonly', 'readonly');
        $(':button').attr("disabled", true);
        //$(":checkbox").attr('readonly', 'readonly');
      }else{
        $("form :input").removeAttr('readonly');
        $(":button").attr("disabled", false);
      }
      return this;
    };
    win.onCenter=function() {
      return this;
    };
    return win;
  },
  submitForm:function(win,id,url,callback){
        uApp.sendForm(id,url, function(ty,rs) {
         if(ty){
            win.onLoadBar(true,true);
            if(rs!==null){
              console.log(rs);
              if(rs.success){
                win.modal('hide');
                win.onLoadBar(false,false);
                if(callback)callback(true,rs);
                else window.location.reload();
              }else{
                win.onLoadBar(false,false);
                alert(rs.alert);
                if(callback)callback(false,rs.alert,rs.valid||0);
              }
            }
         }
        });
    },
  sendForm: function(id, url, callback) {
    $('#' + id).validator().on('submit', function(event) {
      if (event.isDefaultPrevented()) {
        callback && callback(false,null);
        alert('Porfavor introduce la información requerida...');
      } else {
        if (!("FormData" in window)) {
          alert('Tu navegador no soporta todas las opciones requeridas por este sistema, para hacer de ésta una mejor experiencia, te sugerimos que utilices Google Chrome.');
          return false;
        }
        callback && callback(true,null);
        var data = new FormData($('#' + id)[0]);
        $.ajax({
          type: 'POST',
          url: url,
          dataType: 'text',  // what to expect back from the PHP script, if anything
          cache: false,
          data: data,
          contentType: false,
          processData: false,
          beforeSend: function() {},
          success: function(result) {
            callback && callback(true,uApp.jsonDecode(result));
          },
          error: function() {}
        });
      }
      return false;
    });
  },

  sendFile: function(id, url, callback) {
      if (!("FormData" in window)) {
          alert('Tu navegador no soporta todas las opciones requeridas por este sistema, para hacer de ésta una mejor experiencia, te sugerimos que utilices Google Chrome.');
          return false;
      }
      var data = new FormData($('#' + id)[0]);
      $.ajax({
          type: 'POST',
          url: url,
          dataType: 'text',  // what to expect back from the PHP script, if anything
          cache: false,
          data: data,
          contentType: false,
          processData: false,
          beforeSend: function() {},
          success: function(result) {
            callback && callback(uApp.jsonDecode(result));
          },
          error: function() {}
      });
  },

  sendData:function(url,data,callback){
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        success: function (rs) {
          callback && callback(rs);
        },
        data: data
    });
  },
  getData: function(url,data,callback,ty) {
    var ld=ty?undefined:uHtml.onLoading(null,true,'Espere mientras se cargan los datos.');
    callback && callback(true,null);
    $.ajax({
          type: 'POST',
          url: url,
          dataType: 'text',  // what to expect back from the PHP script, if anything
          data: data || {},
          contentType: false,
          processData: false,
          beforeSend: function() {},
          success: function(result) {
            ld && ld.onClose();
            callback && callback(true,uApp.jsonDecode(result));
          },
          error: function() {
            alert('Ocurrio un error de conexión, intente mas tarde...');
            ld && ld.onClose();
            callback && callback(false,null);
          }
    });
    return false;
  },
  getAjax: function(url,callback,ty) {
    var ld=ty?undefined:uHtml.onLoading(null,true,'Espere mientras se cargan los datos.');
    callback && callback(true,null);
    $.ajax({
          type: 'GET',
          url: url,
          success: function(result) {
            ld && ld.onClose();
            callback && callback(true,result);
          },
          error: function() {
            alert('Ocurrio un error de conexión, intente mas tarde...');
            ld && ld.onClose();
            callback && callback(false,null);
          }
    });
    return false;
  },
  subWrapStr:function(str,sz,prx){
    if(str.length <sz)return str;
    var st = str.substr(0, sz);
    return  st.substr(0, Math.min(st.length, st.lastIndexOf(' ')))+(prx||'');
  },
  scrollToBottom:function(id){
    $(id).animate({ scrollTop: $(id)[0].scrollHeight}, 1000);
  },
  scrollToTop:function(id) {
    $(id).animate({ scrollTop: 0}, 1000);
  },
  poolRz:[],
  callResize : function(callback) {
    if(typeof callback == 'function'){
      var width = window.innerWidth || screen.width || $(window).width();
      var height = window.innerHeight || screen.height || (window).height();
      callback(width,height,0);
      return uApp.poolRz.push(callback) - 1 ;
    };
    return null;
  },
  delResize : function(idx) {
    idx!==null && (uApp.poolRz[idx]=null);
  },
  onCallResize:function(ty){
    var width = window.innerWidth || screen.width || $(window).width();
    var height = window.innerHeight || screen.height || (window).height();
    for (var i = 0; i < uApp.poolRz.length; i++) {
      //console.log(uApp.poolRz[i]);
      typeof uApp.poolRz[i] == 'function' && uApp.poolRz[i](width,height,ty);
    }
  }
};




$(function() {
  $(".navbar-expand-toggle").click(function() {
    $(".app-container").toggleClass("expanded");
    return $(".navbar-expand-toggle").toggleClass("fa-rotate-90");
  });
  $(".navbar-right-expand-toggle").click(function() {
    $(".navbar-right").toggleClass("expanded");
    return $(".navbar-right-expand-toggle").toggleClass("fa-rotate-90");
  });
  $(".side-menu .nav .dropdown").on('show.bs.collapse', function() {
    return $(".side-menu .nav .dropdown .collapse").collapse('hide');
  });
  $(window).resize(function() {uApp.onCallResize(1); });
  window.onorientationchange = function() { uApp.onCallResize(2); };
/*
$(function() {
  $('select').select2();
  $('.toggle-checkbox').bootstrapSwitch({ size: "small" });
  $('.match-height').matchHeight();
});
$(function() {
  return $('.datatable').DataTable({
    "dom": '<"top"fl<"clear">>rt<"bottom"ip<"clear">>'
  });
});
*/
  /*
  return
  */
});
//$(window).on('resize', centerModals);
