$(function () {

  plugins= ["search","sort"];
  if(ROLE_PARAM) plugins= ["dnd", "search", "unique","sort"];


  //Doc : http://www.jstree.com/
  $('#jstree').jstree({
    "plugins" : plugins,
    'core' : {
      'multiple' : false,
      'check_callback' : true,
      'data' : json
    },
  });





  $('#jstree').on('changed.jstree', function (e, data) {
    //console.log(data.node);
    //console.log(data.node.children.length);
    var i, j;
    //Boucle dans le cas ou il y aurait plusieurs sélections ce qui normalement est bloqué
    for(i = 0, j = data.selected.length; i < j; i++) {
      node=data.instance.get_node(data.selected[i]);
      $("#node_id").val(node.id);
      $("#node_terme").val(node.text);
      $("#node_nb_enfants").val(node.children.length);

      get_description()

      //** Recherche description **********************
      /*
      description="";
      $.each(json, function(k, v) {
        if(v.id==node.id) description=v.description;
        //console.log(v.id+" : "+v.description);
      });
      $("#node_description").val(description);
      */
      //***********************************************


    }

    if(data.selected.length>0) {
      $("#node_detail").show(100);
    } else {
      $("#node_detail").hide(100);
    }

  });







  //Recherche
  var to = false;
  $('#recherche').keyup(function () {
    if(to) { clearTimeout(to); }
    to = setTimeout(function () {
      var v = $('#recherche').val();
      $('#jstree').jstree(true).search(v);
    }, 250);
  });






  //Texte change
  $('#jstree').on("set_text.jstree", function (e, data) {
    console.log(data.obj.id+" => "+data.obj.text);
  });

  //Position change
  $('#jstree').on("move_node.jstree", function (e, data) {
    console.log(data.node.id+" : Parent devient : "+data.node.parent);
    if(ROLE_PARAM) set_parent(data.node.id,data.node.parent);
    //$('#jstree').jstree('deselect_all');
    //$('#jstree').jstree('select_node', data.node.id);
  });




  $('#developper').on('click', function () {
    $('#jstree').jstree('open_all');
  });

  $('#reduire').on('click', function () {
    $('#jstree').jstree('close_all');
  });

  $('#ajouter').on('click', function () {
    parent=$("#node_id").val();
    if(ROLE_PARAM) create_terme(parent);
  });

  $('#ajouter_racine').on('click', function () {
    if(ROLE_PARAM) create_terme('');
  });

  
  $('#node_terme').on('change', function () {
    if(ROLE_PARAM) set_terme();
  });

  $('#node_description').on('change', function () {
    if(ROLE_PARAM) set_description();
  });


  $('#node_supprimer').on('click', function () {
    if(ROLE_PARAM) {
      remove_terme(node_id);
    }
    return false;
  });

  $("#node_terme,#node_description").focus(function(){
      this.select();
  });

});






function set_terme() {
  node_id=$("#node_id").val();
  terme=$("#node_terme").val();

  //console.log("node_terme_change");
  jQuery.ajax({
    type: 'GET', // Le type de ma requete
    dataType: "json",
    url: '/webservice/set_terme',   // L'url vers laquelle la requete sera envoyee
    data: {
        terme: terme,    // Les donnees que l'on souhaite envoyer au serveur au format JSON
        id: node_id,
        webservice_token: webservice_token
    }, 
    success: function(data, textStatus, jqXHR) {
      //console.log(data.err);
      if(data.err!="") {
        alert(data.err);
      } else {
        $('#jstree').jstree('rename_node', node_id, terme); 
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert("Problème d'accès au serveur");
    }
  }); 
}



function set_parent(node_id,parent) {
  jQuery.ajax({
    type: 'GET', // Le type de ma requete
    dataType: "json",
    url: '/webservice/set_parent',   // L'url vers laquelle la requete sera envoyee
    data: {
        id: node_id,
        parent: parent,
        webservice_token: webservice_token
    }, 
    success: function(data, textStatus, jqXHR) {
      if(data.err!="") {
        alert(data.err);
      } else {
        $('#jstree').jstree('deselect_all');
        $('#jstree').jstree('select_node', node_id);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert("Problème d'accès au serveur");
    }
  }); 
}







function set_description() {
  node_id=$("#node_id").val();
  description=$("#node_description").val();
  jQuery.ajax({
    type: 'GET', // Le type de ma requete
    dataType: "json",
    url: '/webservice/set_description',   // L'url vers laquelle la requete sera envoyee
    data: {
        description: description,    // Les donnees que l'on souhaite envoyer au serveur au format JSON
        id: node_id,
        webservice_token: webservice_token
    }, 
    success: function(data, textStatus, jqXHR) {
      if(data.err!="") {
        alert(data.err);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert("Problème d'accès au serveur");
    }
  }); 
}


function get_description() {
  node_id=$("#node_id").val();
  jQuery.ajax({
    type: 'GET', // Le type de ma requete
    dataType: "json",
    url: '/webservice/get_description',   // L'url vers laquelle la requete sera envoyee
    data: {
        id: node_id
    }, 
    success: function(data, textStatus, jqXHR) {
      if(data.err!="") {
        alert(data.err);
      } else {
        $("#node_description").val(data.description);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert("Problème d'accès au serveur");
    }
  }); 
}

function remove_terme(node_id) {


  nb_enfants=$("#node_nb_enfants").val();
  if(nb_enfants>0) {
    alert("Par sécurité, il n'est pas autorisé de supprimer un terme ayant des enfants !");
  } else {
    if (confirm("ATTENTION : La suppression d'un terme peut entraîner des anomalies dans les applications l’utilisant !\nVoulez-vous vraiment supprimer ce terme ?")) {
      //node_id=$("#node_id").val();

      jQuery.ajax({
        type: 'GET', // Le type de ma requete
        dataType: "json",
        url: '/webservice/remove_terme',   // L'url vers laquelle la requete sera envoyee
        data: {
            id: node_id,
            webservice_token: webservice_token
        }, 
        success: function(data, textStatus, jqXHR) {
          if(data.err!="") {
            alert(data.err);
          } else {
            $('#jstree').jstree('delete_node', node_id);
            $('#jstree').jstree('deselect_all');
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Problème d'accès au serveur");
        }
      }); 
    } 
  }





}


function create_terme(parent) {
  jQuery.ajax({
    type: 'GET', // Le type de ma requete
    dataType: "json",
    url: '../webservice/create_terme',   // L'url vers laquelle la requete sera envoyee
    data: {
        id_thesaurus: id_thesaurus,
        parent: parent,
        webservice_token: webservice_token
    }, 
    success: function(data, textStatus, jqXHR) {
      if(data.err!="") {
        alert(data.err);
      } else {
        if(parent=="") {
          node_id=$('#jstree').jstree('create_node',"#",{'id':data.id,'text':'Nouveau'});
        } else {
          node_id=$('#jstree').jstree('create_node',parent,{'id':data.id,'text':'Nouveau'});
        }
        $('#jstree').jstree('deselect_all');
        $('#jstree').jstree('select_node', node_id);
        $("#node_terme").select();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert("Problème d'accès au serveur");
    }
  }); 
}









