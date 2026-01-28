## Silverstripe Tree Test

This is a repository to test the silverstripe cms tree.

To install, just run `ddev start`, it will run `composer install` and `sake db:build`. `silverstripe-populate` will create the test pages. The site will be available under https://silverstripe-tree-test.ddev.site. The error will be visible under: 

- https://silverstripe-tree-test.ddev.site/admin/pages/edit/show/55
- https://silverstripe-tree-test.ddev.site/admin/pages/edit/show/61

## Findings:

### tree not opening when editing a page on level 4
When clicking through the tree in the backend, it reloads the subtrees when clicking on an unexpanded node. This works so far, though sometimes nodes might be added twice in somce circumstances.

### How to reproduce:
* click on Test 2 > Test 10 > Test 34 -> it reloads the children of 34, pages Test 55 and Test 61

When opening page "Test 55" in the CMS, everything seems fine.

When reloading "Test 55", CMSMain gets the basic tree (three levels) and then an ajax call is sent (/admin/pages/edit/updatetreenodes/?ids=55). This returns, that page id=34 is the parent of "Test 55", so it calls "getsubtree?ID=34&ajax=1" which updates the tree.

It seems that after updating the tree there is no more attempt to expand the tree to show the node for "Test 55", so the tree stays flat. Also, when opening the tree manually, the node "Test55" is added twice. Maybe this is the source of the tree not expanding correctly?

### even weirder behaviour on level 5
Now let's edit Test 55 > Test 61 and reload the page.

The inital tree (3 levels) is rendered (without knowing which page we currently edit) in CMSMain.TreeAsUL.

It calls updatetreenodes for ID 61, which returns that 55 is the parent. 55 isn't in the current tree, so it calls "getsubtree?ID=0&ajax=1", which returns the whole tree but only "Your Site Name" is visible and nothing is expanded at all.

#### Didn't test on Level 6 or 7


## Possible solutions:
* if the initial tree would know, which page we are editing, it could expand the tree to show the current page, even if it's more levels deep than the default tree
* updatetreenodes (in Admin's LeftAndMain.Tree.js) could recursively get parent nodes until a parent is already present in the tree



