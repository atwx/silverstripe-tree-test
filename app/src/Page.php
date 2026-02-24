<?php

namespace {

    use DNADesign\Populate\Populate;
    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Forms\SearchableDropdownField;
    use SilverStripe\Forms\TreeDropdownField;

    class Page extends SiteTree
    {
        private static $db = [
        ];

        private static $has_one = [
            "PointlessLink" => Page::class,
        ];

        public function requireDefaultRecords()
        {
            parent::requireDefaultRecords();
            if(Page::get()->filter('URLSegment', 'test-1')->count() == 0) {
                Populate::requireRecords();
            }
        }

        public function getCMSFields()
        {
            $fields = parent::getCMSFields();
            $fields->replaceField(
                'PointlessLinkID',
                TreeDropdownField::create(
                    'PointlessLinkID',
                    'Pointless Link',
                    Page::class
                )
            );
            return $fields;
        }
    }
}
