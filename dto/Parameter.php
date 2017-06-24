<?php
    class Parameter{
        private $page = "";
        private $no = "";
        private $parent = "";
        private $depth = "";
        private $index = "";
        private $type = "";

        public function getParameter(){
            return "?page=".$this->page.'&no='.$this->no.'&parent='.$this->parent.'&depth='.$this->depth.'$index='.$this->index.'&type='.$this->type;
        }

        /**
         * @param string $page
         */
        public function setPage($page)
        {
            $this->page = $page;
        }

        /**
         * @param string $no
         */
        public function setNo($no)
        {
            $this->no = $no;
        }

        /**
         * @param string $parent
         */
        public function setParent($parent)
        {
            $this->parent = $parent;
        }

        /**
         * @param string $depth
         */
        public function setDepth($depth)
        {
            $this->depth = $depth;
        }

        /**
         * @param string $index
         */
        public function setIndex($index)
        {
            $this->index = $index;
        }

        /**
         * @param string $type
         */
        public function setType($type)
        {
            $this->type = $type;
        }

        public function getType(){
            return $this->type;
        }

    }
?>