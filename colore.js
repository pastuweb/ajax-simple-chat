function mover( id )
{
  var obj = document.getElementById( id );
  obj.style.borderColor = "black";
}
function mout( id )
{
  var obj = document.getElementById( id );
  obj.style.borderColor = "white";
}
function selectColor( color )
{
  document.getElementById( "color" ).value = color;
  document.getElementById( "sampleText" ).style.color = color;
}
