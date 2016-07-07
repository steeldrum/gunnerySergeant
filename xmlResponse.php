<?PHP
  //namespace Chirp;

// Original PHP code by Chirp Internet: www.chirp.com.au
// Please acknowledge use of this code by including this header.

class xmlResponse
{

public  function start()
  {
    //header("Content-Type: text/xml");
header('Content-Type: application/xml, charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
printf("\n");
    echo "<response>";
    printf("\n");
  }

public  function command($method, $params=array(), $encoded=array())
  {
    echo "  <command method=\"$method\">";
printf("\n");
    if($params) {
      foreach($params as $key => $val) {
        echo "    <$key>" . htmlspecialchars($val) . "</$key>";
printf("\n");        
      }
    }
    if($encoded) {
      foreach($encoded as $key => $val) {
        echo "    <$key><![CDATA[$val]]></$key>";
printf("\n");        
      }
    }
    echo "  </command>";
    printf("\n");
  }

  //function end()
public  function endxml()
  {
    echo "</response>";
      printf("\n");
    exit;
  }

}
?>
