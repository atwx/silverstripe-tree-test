<?php

namespace {

    use DNADesign\Populate\Populate;
    use SilverStripe\CMS\Model\SiteTree;

    class Page extends SiteTree
    {
        private static $db = [];

        private static $has_one = [];

        public function requireDefaultRecords()
        {
            parent::requireDefaultRecords();
            Populate::requireRecords();
        }
    }
}
