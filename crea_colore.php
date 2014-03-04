<?php
function hsb( $h, $s, $v )
{
  $r = $g = $b = 0;
  if ( $s == 0 ) 
  { 
    $r = $g = $b = $v;
  }
  else
  {
    $h = $h / 60;
    $i = floor( $h );
    $f = $h - $i;
    $p = $v * ( 1 - $s );
    $q = $v * ( 1 - $s * $f );
    $t = $v * ( 1 - $s * ( 1 - $f ) );
    switch( $i ) {
      case 0: $r = $v; $g = $t; $b = $p; break;
      case 1: $r = $q; $g = $v; $b = $p; break;
      case 2: $r = $p; $g = $v; $b = $t; break;
      case 3: $r = $p; $g = $q; $b = $v; break;
      case 4: $r = $t; $g = $p; $b = $v; break;
      default: $r = $v; $g = $p; $b = $q; break;
    }
  }
  return array( $r, $g, $b );
}

function hsb2hex( $h, $s, $b )
{
   list( $r, $g, $b ) = hsb( $h, $s, $b );
   return sprintf( "#%02x%02x%02x", $r, $g, $b );
}
?>