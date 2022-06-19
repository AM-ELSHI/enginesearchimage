<?php
    /**
     * Class GoogleImages and Bing
     * Author: Armand MOUELE
     * Date: 12 January 2021
     * https://github.com/AM-ELSHI
     * Subject: Class to get a image by Google and Bing Images
    */
    
    class ImageBySearchEngine{
        private $_engineMotor = 'google'; //bing
        private $_engineLimit = 1; 

        public function __construct($initParam=null){ 
            if($initParam !=null && is_array($initParam)){
                if(isset($initParam['engine']) && !empty($initParam['engine'])){
                    $this->_engineMotor = $initParam['engine'];
                }
                if(isset($initParam['limit']) && !empty($initParam['limit'])){
                    $this->_engineLimit = $initParam['limit'];
                }
            }
        }
        public function search($query, $limit=null, $search_engine=null){
            $query = trim(str_replace(" ", "+", $query));

            $limit = ($limit==null) ? $this->_engineLimit : $limit ;
            $search_engine = ($search_engine==null) ? $this->_engineMotor : $search_engine ;

            //Open a connection with Search Engine Images
            $url = $search_engine == "google"
                ? "https://www.google.com/search?q=". $query ."&tbm=isch"
                : "https://www.bing.com/images/search?q=" . $query . "&scope=images";

            $fp = @file_get_contents($url);

            if($fp === FALSE)
                return null;

            if (!$fp)
                return null;

            //Search for all img tags on the page
            preg_match_all('/<img[^>]+>/i',$fp, $result);

            $result = $result[0];
            $images = [];
            //Here we will have several images in the $result array
            //It is necessary to scroll through it to search for valid images
            for($i = 1; $i < count($result); $i++){
                //Get prop img content
                preg_match( '@src="([^"]+)"@' , $result[$i], $match );
                $result[$i] = array_pop($match);
                /*If it is a valid image, assign
                the value for variable $ image and for the loop*/
                if (@getimagesize($result[$i])) {
                    if(count($images) == $limit)
                        break;
                    $image["uri"] = trim($result[$i]);
                    array_push($images, $image);
                }
            }
            //returns a array containing the URIs of images
            return $images;
        }
    }