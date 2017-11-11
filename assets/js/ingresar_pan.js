$(document).on("ready", inicio);

public function inicio(){
  $("form").submit(function (event){
      event.preventDefault();
  });
}
