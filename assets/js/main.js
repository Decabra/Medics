function toggleClass(element){

  var sidebar_parent = document.getElementById('pms-sidebar-nav').children;

  for(var i = 0; i < sidebar_parent.length; i++){
    sidebar_parent[i].classList.remove("active");

  }
  element.classList.add("active");

}

var i = 0;
function shiftClass(id, steer) {
      var child = document.getElementById(id).children;
      if(child[i].classList.contains(steer) == true) {
        child[i].classList.remove(steer);
        i++;
      }
      if (i >= 4){
        i = 0;
      }
      child[i].classList.add(steer);
}

function shuffleClass(id_one, id_two){

  var add = document.getElementById(id_one);
  var remove = document.getElementById(id_two);
  add.classList.add('respond-to-btn');
  remove.classList.remove('respond-to-btn');

}

function addClass(id){
  var add = document.getElementById(id);
  add.classList.add('respond-to-btn');
}

function removeClass(id){
  var remove = document.getElementById(id);
  remove.classList.remove('respond-to-btn');

}

function MoveDiv() {
	var fragment = document.createDocumentFragment();
	fragment.appendChild(document.getElementById('pms-add-sales'));
	document.getElementById('customers').appendChild(fragment);
}
