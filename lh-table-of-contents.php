<?php
/*
 * Plugin Name: LH Table of contents
 * Plugin URI: https://lhero.org/portfolio/lh-table-of-contents/
 * Description: Automatically create a wiki like TOC (table of contents) in your posts or pages using shortcode based on your headings.
 * Author: Peter Shaw
 * Text Domain: lh_toc
 * Domain Path: /languages
 * Version: 1.05
 * Author URI: https://shawfactor.com/
*/

// If this file is called directly, abandon ship.
if ( ! defined( 'WPINC' ) ) {
	die;
}


if (!class_exists('LH_table_of_contents_plugin')) {

class LH_table_of_contents_plugin {
    
private static $instance;

    
protected $h_count = 0;

static function return_plugin_namespace(){

    return 'lh_toc';

    }
    
static function get_toc_elements($elements = array('h2','h3','h4')){
    
    return $elements;  
    
}


static function DOMinnerHTML($element) { 
    $innerHTML = ""; 
    $children  = $element->childNodes;

    foreach ($children as $child) 
    { 
        $innerHTML .= $element->ownerDocument->saveHTML($child);
    }

    return $innerHTML; 
} 

private function maybe_add_id($element){
    
         $this->h_count++;
         
         $id = $element->getAttribute('id');
         
         
         
         if (empty($id)){
             
             
             
             $inner = self::DOMinnerHTML($element);
             $hash = wp_hash($inner);
             $element->setAttribute("id", self::return_plugin_namespace().'-'.$this->h_count.'-'.$hash);
             
             
         }

    
}
    
private function maybe_add_class($element){
    
    
    $class = $element->getAttribute('class');

if (empty($class)){
    
$element->setAttribute("class", self::return_plugin_namespace().'-index');  
    
} elseif (strpos($class, self::return_plugin_namespace().'-index') !== false){
    
//do nothing  
    
} else {
    
 $element->setAttribute("class", $class.' '.self::return_plugin_namespace().'-index');     
    
    
}
    
    
}
 
 
	
   
    

    

    
    
    

   
   
public function add_ids_and_classes($content){
       

$haystack = self::get_toc_elements();
     
libxml_use_internal_errors(true);    

$doc = new DOMDocument;

$doc->loadHTML( mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );

foreach($doc->getElementsByTagName('*') as $element ){
    
    //print_r($element);
    
    //exit;
   
 if (in_array($element->tagName, $haystack)) { 
     

     

$this->maybe_add_id($element);
    
$this->maybe_add_class($element);    


 }
     
     
 }
 

$content = $doc->saveHTML();

libxml_clear_errors();
 
return $content;
       
       
   }
   
   
   
   
public function get_index($content){
       

$doc = new DOMDocument();

// load the HTML into the DomDocument object (this would be your source HTML)
$doc->loadHTML("<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\"></head><body>".$content."</body></html>");

$index = array();

foreach($doc->getElementsByTagName('*') as $element ){
    
        $class = $element->getAttribute('class');
        $id = $element->getAttribute('id');
        
        
        if (!empty($class) and !empty($id) and (strpos($class, self::return_plugin_namespace().'-index') !== false)){
            
            $add = array();
            $add['tagName'] = $element->tagName;
            $add['textContent'] = $element->textContent;
            $add['id'] = $id;
            
            $index[] = $add;
            
            
            
            
        }
    
    

    

}

if (!empty($index)){

return $index;

} else {
    
return false;    
    
}

    
    
}

    /*
    *  the_content
    *
    *  @description: 
    */
    
    public function the_content( $content ){



        if ((is_singular()) and (!is_admin()) and (strpos($content, '<!-- lh_toc -->') !== false)  ) {


$content = str_replace("<p><!-- lh_toc --></p>","<!-- lh_toc -->",$content);
        
$content = $this->add_ids_and_classes($content);

if ($index = $this->get_index($content)){
    
$toc_content = '';
    
foreach($index as $item ){
    
$toc_content .= '<li class="'.$item['tagName'].'"><a href="#'.$item['id'].'">'.$item['textContent'].'</a></li>';    
    
    
}

$toc = '
        <ol class="lh_table_of_contents">
        '.$toc_content.'</ol>
        ';


$content = str_replace("<!-- lh_toc -->",$toc,$content);    
    
    
}
        
        
return $content;

} else { 

            return $content; 
        } 
    }
    
public function plugins_loaded(){


add_filter( 'the_content', array($this, 'the_content'), 9, 1 ); 
    
    
}
    
     /**
     * Gets an instance of our plugin.
     *
     * using the singleton pattern
     */
    public static function get_instance(){
        if (null === self::$instance) {
            self::$instance = new self();
        }
 
        return self::$instance;
    }   
    
    
    public function __construct() {

/* Initialize the plugin */       
 add_action( 'plugins_loaded', array($this,'plugins_loaded'));


}
    
    
}

$lh_table_of_contents_instance = LH_table_of_contents_plugin::get_instance();

}

?>