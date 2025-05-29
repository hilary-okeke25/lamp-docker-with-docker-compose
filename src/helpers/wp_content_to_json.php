<?php

/*

    Cleaner to prepare wordpress content for use by AI Agent.

*/

namespace SiteAgent\helpers;

class WordpressPostContentToPlainJson{


    private $html_tags_to_remove = [
        "a", "abbr", "acronym", "address", "applet", "area",
        "article", "aside", "audio", "b", "base", "bdi",
        "bdo", "blockquote", "body", "br", "button", "canvas",
        "caption", "cite", "code", "col", "colgroup", "data",
        "datalist", "dd", "del", "details", "dfn", "dialog",
        "div", "dl", "dt", "em", "embed", "fieldset", "figcaption",
        "figure", "footer", "form", "h1", "h2", "h3", "h4",
        "h5", "h6", "head", "header", "hr", "html", "i",
        "iframe", "img", "input", "ins", "kbd", "label",
        "legend", "li", "link", "main", "map", "mark",
        "meta", "meter", "nav", "noscript", "object", "ol",
        "optgroup", "option", "output", "p", "param", "picture",
        "pre", "progress", "q", "rp", "rt", "ruby", "s",
        "samp", "script", "section", "select", "small", "source",
        "span", "strong", "style", "sub", "summary", "sup",
        "svg", "table", "tbody", "td", "template", "textarea",
        "tfoot", "th", "thead", "time", "title", "tr",
        "track", "u", "ul", "var", "video", "wbr"
    ];

    //accepts array
    public function doConversion($wp_content, $key="post_content"){

        $replaced_explamation_marks = $this->remove_explamation_mark_tags_so_text_is_compatible_for_preg_replace($wp_content, $key);
 

        echo "Cleaned exclamation marks " . json_encode($replaced_explamation_marks) . " \r\n";


         $replaced_html = $this->replace_all_html_tags_leaving_just_content($replaced_explamation_marks, $key); 



        echo "removed html marks " . json_encode($replaced_html) . " \r\n";


         return $replaced_html;


    }
 

    private function replace_all_html_tags_leaving_just_content($string_arr, $key){

        for($i = 0; $i < count($string_arr); $i++){ 
            
            $string = $string_arr[$i][$key]; 

            $removedHtmlTags = '';
            foreach($this->html_tags_to_remove as $tag){

                $replacedText = $string;

                while(str_contains($tag, $replacedText)){
                  
                  $replacedText = preg_replace('/'.$tag.'[^>]*>(.*?)<\/'.$tag.'>/is', '$1', $replacedText);

                }

                $removedHtmlTags = $replacedText;
            }

            $string_arr[$i][$key] = $removedHtmlTags;


            
 
        }

        return $string_arr;
    }


 

    private function remove_explamation_mark_tags_so_text_is_compatible_for_preg_replace($string_arr, $key){ 

        for($i = 0; $i < count($string_arr); $i++){
            $string = $string_arr[$i][$key];

            $remove_opening_e_tags = str_replace("<!--", "<replace_me>", $string);
            $remove_closing_e_tags = str_replace("-->", "</replace_me>", $remove_opening_e_tags);

            $search = "/<replace_me>.*?<\/replace_me>/s";
            $replace = "";
            $result = preg_replace($search, $replace, $remove_opening_e_tags);

            $string_arry[$i][$key] = $result;
        }

        return $string_arr;
    }

}







?>