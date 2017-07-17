<?php
/**
 * UI functions
 *
 * @copyright 2009-2017 Vanilla Forums Inc.
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU GPL v2
 * @package Core
 * @since 2.0
 */

if (!function_exists('alternate')) {
    /**
     * Write alternating strings on each call.
     *
     * Useful for adding different classes to alternating lines in a list
     * or table to enhance their readability.
     *
     * @param string $odd The text for the first and every further "odd" call.
     * @param string $even The text for the second and every further "even" call.
     * @param string $attributeName The html attribute name that should embrace $even/$odd output.
     * @return string
     */
    function alternate($odd = '', $even = 'Alt', $attributeName = 'class') {
        static $b = false;
        if ($b = !$b) {
            $value = $odd;
        } else {
            $value = $even;
        }

        if ($value != '' && $attributeName != '') {
            return ' '.$attributeName.'="'.$value.'"';
        } else {
            return $value;
        }
    }
}

if (!function_exists('dashboardSymbol')) {
    /**
     * Render SVG icons in the dashboard. Icon must exist in applications/dashboard/views/symbols.php
     *
     * @param string $name The name of the icon to render. Must be set in applications/dashboard/views/symbols.php.
     * @param string $class If set, overrides any 'class' attribute in the $attr param.
     * @param array $attr The dashboard symbol attributes. The default 'alt' attribute will be set to $name.
     * @return string An HTML-formatted string to render svg icons.
     */
    function dashboardSymbol($name, $class = '', array $attr = []) {
        if (empty($attr['alt'])) {
            $attr['alt'] = $name;
        }

        if (!empty($class)) {
            $attr['class'] = $class.' ';
        } else {
            $attr['class'] = isset($attr['class']) ? $attr['class'].' ' : '';
        }

        $baseCssClass = 'icon icon-svg-'.$name;
        $attr['class'] .= $baseCssClass;

        return '<svg '.attribute($attr).' viewBox="0 0 17 17"><use xlink:href="#'.$name.'" /></svg>';
    }
}

if (!function_exists('bigPlural')) {
    /**
     * English "plural" formatting for numbers that can get really big.
     *
     * @param $Number
     * @param $Singular
     * @param bool $Plural
     * @return string
     */
    function bigPlural($Number, $Singular, $Plural = false) {
        if (!$Plural) {
            $Plural = $Singular.'s';
        }
        $Title = sprintf(t($Number == 1 ? $Singular : $Plural), number_format($Number));

        return '<span title="'.$Title.'" class="Number">'.Gdn_Format::bigNumber($Number).'</span>';
    }
}

if (!function_exists('helpAsset')) {
    /**
     * Formats a help element and adds it to the help asset.
     *
     * @param $title
     * @param $description
     */
    function helpAsset($title, $description) {
        Gdn_Theme::assetBegin('Help');
        echo '<aside role="note" class="help">';
        echo wrap($title, 'h2', ['class' => 'help-title']);
        echo wrap($description, 'div', ['class' => 'help-description']);
        echo '</aside>';
        Gdn_Theme::assetEnd();
    }
}

if (!function_exists('heading')) {
    /**
     * Formats a h1 header block for the dashboard. Only to be used once on a page as the h1 header.
     * Handles url-ifying. Adds an optional button or return link.
     *
     * @param string $title The page title.
     * @param string $buttonText The text appearing on the button.
     * @param string $buttonUrl The url for the button.
     * @param string|array $buttonAttributes Can be string CSS class or an array of attributes. CSS class defaults to `btn btn-primary`.
     * @param string $returnUrl The url for the return chrevron button.
     * @return string The structured heading string.
     */
    function heading($title, $buttonText = '', $buttonUrl = '', $buttonAttributes = [], $returnUrl = '') {

        if (is_string($buttonAttributes)) {
            $buttonAttributes = ['class' => $buttonAttributes];
        }

        if ($buttonText !== '') {
            if (val('class', $buttonAttributes, false) === false) {
                $buttonAttributes['class'] = 'btn btn-primary';
            }
            $buttonAttributes = attribute($buttonAttributes);
        }

        $button = '';

        if ($buttonText !== '' && $buttonUrl === '') {
            $button = '<button type="button" '.$buttonAttributes.'>'.$buttonText.'</button>';
        } else if ($buttonText !== '' && $buttonUrl !== '') {
            $button = '<a '.$buttonAttributes.' href="'.url($buttonUrl).'">'.$buttonText.'</a>';
        }

        $title = '<h1>'.$title.'</h1>';

        if ($returnUrl !== '') {
            $title = '<div class="title-block">
                <a class="btn btn-icon btn-return" aria-label="Return" href="'.url($returnUrl).'">'.
                    dashboardSymbol('chevron-left').'
                </a>
                <h1>'.$title.'</h1>
            </div>';
        }

        return '<header class="header-block">'.$title.$button.'</header>';
    }
}


if (!function_exists('subheading')) {
    /**
     * Renders a h2 subheading for the dashboard.
     *
     * @param string $title The subheading title.
     * @param string $description The optional description for the subheading.
     * @return string The structured subheading string.
     */
    function subheading($title, $description = '') {
        if ($description === '') {
            return '<h2 class="subheading">'.$title.'</h2>';
        } else {
            return '<header class="subheading-block">
                <h2 class="subheading-title">'.$title.'</h2>
                <div class="subheading-description">'.$description.'</div>
            </header>';
        }
    }
}

if (!function_exists('badge')) {
    /**
     * Outputs standardized HTML for a badge.
     *
     * A badge generally designates a count, and displays with a contrasting background.
     *
     * @param string|int $badge Info to put into a badge, usually a number.
     * @return string Badge HTML string.
     */
    function badge($badge) {
        return ' <span class="badge">'.$badge.'</span> ';
    }
}

if (!function_exists('popin')) {
    /**
     * Outputs standardized HTML for a popin badge.
     *
     * A popin contains data that is injected after the page loads.
     * A badge generally designates a count, and displays with a contrasting background.
     *
     * @param string $rel Endpoint for a popin.
     * @return string Popin HTML string.
     */
    function popin($rel) {
        return ' <span class="badge js-popin" rel="'.$rel.'"></span> ';
    }
}

if (!function_exists('icon')) {
    /**
     * Outputs standardized HTML for an icon.
     *
     * Uses the same css class naming conventions as font-vanillicon.
     *
     * @param string $icon Name of the icon you want to use, excluding the 'icon-' prefix.
     * @return string Icon HTML string.
     */
    function icon($icon) {
        if (substr(trim($icon), 0, 1) === '<') {
            return $icon;
        } else {
        $icon = strtolower($icon);
        return ' <span class="icon icon-'.$icon.'"></span> ';
}
    }
}

if (!function_exists('bullet')) {
    /**
     * Return a bullet character in html.
     *
     * @param string $Pad A string used to pad either side of the bullet.
     * @return string
     *
     * @changes
     *    2.2 Added the $Pad parameter.
     */
    function bullet($Pad = '') {
        //·
        return $Pad.'<span class="Bullet">&middot;</span>'.$Pad;
    }
}

if (!function_exists('buttonDropDown')) {
    /**
     * Write a button drop down control.
     *
     * @param array $Links An array of arrays with the following keys:
     *  - Text: The text of the link.
     *  - Url: The url of the link.
     * @param string|array $CssClass The css class of the link. This can be a two-item array where the second element will be added to the buttons.
     * @param string $Label The text of the button.
     * @since 2.1
     */
    function buttonDropDown($Links, $CssClass = 'Button', $Label = false) {
        if (!is_array($Links) || count($Links) < 1) {
            return;
        }

        $ButtonClass = '';
        if (is_array($CssClass)) {
            list($CssClass, $ButtonClass) = $CssClass;
        }

        if (count($Links) < 2) {
            $Link = array_pop($Links);

            if (strpos(val('CssClass', $Link, ''), 'Popup') !== false) {
                $CssClass .= ' Popup';
            }

            echo anchor($Link['Text'], $Link['Url'], val('ButtonCssClass', $Link, $CssClass));
        } else {
            // NavButton or Button?
            $ButtonClass = concatSep(' ', $ButtonClass, strpos($CssClass, 'NavButton') !== false ? 'NavButton' : 'Button');
            if (strpos($CssClass, 'Primary') !== false) {
                $ButtonClass .= ' Primary';
            }

            // Strip "Button" or "NavButton" off the group class.
            echo '<div class="ButtonGroup'.str_replace(['NavButton', 'Button'], ['', ''], $CssClass).'">';

            echo '<ul class="Dropdown MenuItems">';
            foreach ($Links as $Link) {
                echo wrap(anchor($Link['Text'], $Link['Url'], val('CssClass', $Link, '')), 'li');
            }
            echo '</ul>';

            echo anchor($Label.' '.sprite('SpDropdownHandle'), '#', $ButtonClass.' Handle');
            echo '</div>';
        }
    }
}

if (!function_exists('buttonGroup')) {
    /**
     * Write a button group control.
     *
     * @param array $Links An array of arrays with the following keys:
     *  - Text: The text of the link.
     *  - Url: The url of the link.
     * @param string|array $CssClass The css class of the link. This can be a two-item array where the second element will be added to the buttons.
     * @param string|false $Default The url of the default link.
     * @since 2.1
     */
    function buttonGroup($Links, $CssClass = 'Button', $Default = false) {
        if (!is_array($Links) || count($Links) < 1) {
            return;
        }

        $Text = $Links[0]['Text'];
        $Url = $Links[0]['Url'];

        $ButtonClass = '';
        if (is_array($CssClass)) {
            list($CssClass, $ButtonClass) = $CssClass;
        }

        if ($Default && count($Links) > 1) {
            if (is_array($Default)) {
                $DefaultText = $Default['Text'];
                $Default = $Default['Url'];
            }

            // Find the default button.
            $Default = ltrim($Default, '/');
            foreach ($Links as $Link) {
                if (stringBeginsWith(ltrim($Link['Url'], '/'), $Default)) {
                    $Text = $Link['Text'];
                    $Url = $Link['Url'];
                    break;
                }
            }

            if (isset($DefaultText)) {
                $Text = $DefaultText;
            }
        }

        if (count($Links) < 2) {
            echo anchor($Text, $Url, $CssClass);
        } else {
            // NavButton or Button?
            $ButtonClass = concatSep(' ', $ButtonClass, strpos($CssClass, 'NavButton') !== false ? 'NavButton' : 'Button');
            if (strpos($CssClass, 'Primary') !== false) {
                $ButtonClass .= ' Primary';
            }
            // Strip "Button" or "NavButton" off the group class.
            echo '<div class="ButtonGroup Multi '.str_replace(['NavButton', 'Button'], ['', ''], $CssClass).'">';
            echo anchor($Text, $Url, $ButtonClass);

            echo '<ul class="Dropdown MenuItems">';
            foreach ($Links as $Link) {
                echo wrap(anchor($Link['Text'], $Link['Url'], val('CssClass', $Link, '')), 'li');
            }
            echo '</ul>';
            echo anchor(sprite('SpDropdownHandle', 'Sprite', t('Expand for more options.')), '#', $ButtonClass.' Handle');

            echo '</div>';
        }
    }
}

if (!function_exists('category')) {
    /**
     * Get the current category on the page.
     *
     * @param int $Depth The level you want to look at.
     * @param array $Category
     * @return array
     */
    function category($Depth = null, $Category = null) {
        if (!$Category) {
            $Category = Gdn::controller()->data('Category');
        } elseif (!is_array($Category)) {
            $Category = CategoryModel::categories($Category);
        }

        if (!$Category) {
            $Category = Gdn::controller()->data('CategoryID');
            if ($Category) {
                $Category = CategoryModel::categories($Category);
            }
        }
        if (!$Category) {
            return null;
        }

        $Category = (array)$Category;

        if ($Depth !== null) {
            // Get the category at the correct level.
            while ($Category['Depth'] > $Depth) {
                $Category = CategoryModel::categories($Category['ParentCategoryID']);
                if (!$Category) {
                    return null;
                }
            }
        }

        return $Category;
    }
}

if (!function_exists('categoryUrl')) {
    /**
     * Return a url for a category. This function is in here and not functions.general so that plugins can override.
     *
     * @param string|array $Category
     * @param string|int $Page The page number.
     * @param bool $WithDomain Whether to add the domain to the URL
     * @return string The url to a category.
     */
    function categoryUrl($Category, $Page = '', $WithDomain = true) {
        if (is_string($Category)) {
            $Category = CategoryModel::categories($Category);
        }
        $Category = (array)$Category;

        $Result = '/categories/'.rawurlencode($Category['UrlCode']);
        if ($Page && $Page > 1) {
            $Result .= '/p'.$Page;
        }
        return url($Result, $WithDomain);
    }
}

if (!function_exists('condense')) {
    /**
     *
     *
     * @param string $Html
     * @return mixed
     */
    function condense($Html) {
        $Html = preg_replace('`(?:<br\s*/?>\s*)+`', "<br />", $Html);
        $Html = preg_replace('`/>\s*<br />\s*<img`', "/> <img", $Html);
        return $Html;
    }
}

if (!function_exists('countString')) {
    /**
     *
     *
     * @param $Number
     * @param string $Url
     * @param array $Options
     * @return string
     */
    function countString($Number, $Url = '', $Options = []) {
        if (!$Number && $Number !== null) {
            return '';
        }

        if (is_array($Options)) {
            $Options = array_change_key_case($Options);
            $CssClass = val('cssclass', $Options, '');
        } else {
            $CssClass = $Options;
        }

        if ($Number) {
            $CssClass = trim($CssClass.' Count', ' ');
            return "<span class=\"$CssClass\">$Number</span>";
        } elseif ($Number === null && $Url) {
            $CssClass = trim($CssClass.' Popin TinyProgress', ' ');
            $Url = htmlspecialchars($Url);
            return "<span class=\"$CssClass\" rel=\"$Url\"></span>";
        } else {
            return '';
        }
    }
}

if (!function_exists('cssClass')) {
    /**
     * Add CSS class names to a row depending on other elements/values in that row.
     *
     * Used by category, discussion, and comment lists.
     *
     * @param array|object $Row
     * @return string The CSS classes to be inserted into the row.
     */
    function cssClass($Row, $InList = true) {
        static $Alt = false;
        $Row = (array)$Row;
        $CssClass = 'Item';
        $Session = Gdn::session();

        // Alt rows
        if ($Alt) {
            $CssClass .= ' Alt';
        }
        $Alt = !$Alt;

        // Category list classes
        if (array_key_exists('UrlCode', $Row)) {
            $CssClass .= ' Category-'.Gdn_Format::alphaNumeric($Row['UrlCode']);
        }
        if (val('CssClass', $Row)) {
            $CssClass .= ' Item-'.$Row['CssClass'];
        }

        if (array_key_exists('Depth', $Row)) {
            $CssClass .= " Depth{$Row['Depth']} Depth-{$Row['Depth']}";
        }

        if (array_key_exists('Archive', $Row)) {
            $CssClass .= ' Archived';
        }

        // Discussion list classes.
        if ($InList) {
            $CssClass .= val('Bookmarked', $Row) == '1' ? ' Bookmarked' : '';

            $Announce = val('Announce', $Row);
            if ($Announce == 2) {
                $CssClass .= ' Announcement Announcement-Category';
            } elseif ($Announce) {
                $CssClass .= ' Announcement Announcement-Everywhere';
            }

            $CssClass .= val('Closed', $Row) == '1' ? ' Closed' : '';
            $CssClass .= val('InsertUserID', $Row) == $Session->UserID ? ' Mine' : '';
            $CssClass .= val('Participated', $Row) == '1' ? ' Participated' : '';
            if (array_key_exists('CountUnreadComments', $Row) && $Session->isValid()) {
                $CountUnreadComments = $Row['CountUnreadComments'];
                if ($CountUnreadComments === true) {
                    $CssClass .= ' New';
                } elseif ($CountUnreadComments == 0) {
                    $CssClass .= ' Read';
                } else {
                    $CssClass .= ' Unread';
                }
            } elseif (($IsRead = val('Read', $Row, null)) !== null) {
                // Category list
                $CssClass .= $IsRead ? ' Read' : ' Unread';
            }
        }

        // Comment list classes
        if (array_key_exists('CommentID', $Row)) {
            $CssClass .= ' ItemComment';
        } elseif (array_key_exists('DiscussionID', $Row)) {
            $CssClass .= ' ItemDiscussion';
        }

        if (function_exists('IsMeAction')) {
            $CssClass .= isMeAction($Row) ? ' MeAction' : '';
        }

        if ($_CssClss = val('_CssClass', $Row)) {
            $CssClass .= ' '.$_CssClss;
        }

        // Insert User classes.
        if ($UserID = val('InsertUserID', $Row)) {
            $User = Gdn::userModel()->getID($UserID);
            if ($_CssClss = val('_CssClass', $User)) {
                $CssClass .= ' '.$_CssClss;
            }
        }

        return trim($CssClass);
    }
}

if (!function_exists('dateUpdated')) {
    /**
     *
     *
     * @param $Row
     * @param null $Wrap
     * @return string
     */
    function dateUpdated($Row, $Wrap = null) {
        $Result = '';
        $DateUpdated = val('DateUpdated', $Row);
        $UpdateUserID = val('UpdateUserID', $Row);

        if ($DateUpdated) {
            $UpdateUser = Gdn::userModel()->getID($UpdateUserID);
            if ($UpdateUser) {
                $Title = sprintf(T('Edited %s by %s.'), Gdn_Format::dateFull($DateUpdated), val('Name', $UpdateUser));
            } else {
                $Title = sprintf(T('Edited %s.'), Gdn_Format::dateFull($DateUpdated));
            }

            $Result = ' <span title="'.htmlspecialchars($Title).'" class="DateUpdated">'.
                sprintf(T('edited %s'), Gdn_Format::date($DateUpdated)).
                '</span> ';

            if ($Wrap) {
                $Result = $Wrap[0].$Result.$Wrap[1];
            }
        }

        return $Result;
    }
}

if (!function_exists('anchor')) {
    /**
     * Builds and returns an anchor tag.
     *
     * @param $Text
     * @param string $Destination
     * @param string $CssClass
     * @param array $Attributes
     * @param bool $ForceAnchor
     * @return string
     */
    function anchor($Text, $Destination = '', $CssClass = '', $Attributes = [], $ForceAnchor = false) {
        if (!is_array($CssClass) && $CssClass != '') {
            $CssClass = ['class' => $CssClass];
        }

        if ($Destination == '' && $ForceAnchor === false) {
            return $Text;
        }

        if (!is_array($Attributes)) {
            $Attributes = [];
        }

        $SSL = null;
        if (isset($Attributes['SSL'])) {
            $SSL = $Attributes['SSL'];
            unset($Attributes['SSL']);
        }

        $WithDomain = false;
        if (isset($Attributes['WithDomain'])) {
            $WithDomain = $Attributes['WithDomain'];
            unset($Attributes['WithDomain']);
        }

        $Prefix = substr($Destination, 0, 7);
        if (!in_array($Prefix, ['https:/', 'http://', 'mailto:']) && ($Destination != '' || $ForceAnchor === false)) {
            $Destination = Gdn::request()->url($Destination, $WithDomain, $SSL);
        }

        return '<a href="'.htmlspecialchars($Destination, ENT_COMPAT, 'UTF-8').'"'.attribute($CssClass).attribute($Attributes).'>'.$Text.'</a>';
    }
}

if (!function_exists('commentUrl')) {
    /**
     * Return a URL for a comment. This function is in here and not functions.general so that plugins can override.
     *
     * @param object $Comment
     * @param bool $WithDomain
     * @return string
     */
    function commentUrl($Comment, $WithDomain = true) {
        $Comment = (object)$Comment;
        $Result = "/discussion/comment/{$Comment->CommentID}#Comment_{$Comment->CommentID}";
        return url($Result, $WithDomain);
    }
}

if (!function_exists('discussionUrl')) {
    /**
     * Return a URL for a discussion. This function is in here and not functions.general so that plugins can override.
     *
     * @param object $Discussion
     * @param int|string $Page
     * @param bool $WithDomain
     * @return string
     */
    function discussionUrl($Discussion, $Page = '', $WithDomain = true) {
        $Discussion = (object)$Discussion;
        $Name = Gdn_Format::url($Discussion->Name);

        // Disallow an empty name slug in discussion URLs.
        if (empty($Name)) {
            $Name = 'x';
        }

        $Result = '/discussion/'.$Discussion->DiscussionID.'/'.$Name;

        if ($Page) {
            if ($Page > 1 || Gdn::session()->UserID) {
                $Result .= '/p'.$Page;
            }
        }

        return url($Result, $WithDomain);
    }
}

if (!function_exists('exportCSV')) {
    /**
     * Create a CSV given a list of column names & rows.
     *
     * @param array $columnNames
     * @param array $data
     */
    function exportCSV($columnNames, $data = []) {
        $output = fopen("php://output",'w');
        header("Content-Type:application/csv");
        header("Content-Disposition:attachment;filename=profiles_export.csv");
        fputcsv($output, $columnNames);
        foreach($data as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
    }
}

if (!function_exists('fixnl2br')) {
    /**
     * Removes the break above and below tags that have a natural margin.
     *
     * @param string $Text The text to fix.
     * @return string
     * @since 2.1
     */
    function fixnl2br($Text) {
        $allblocks = '(?:table|dl|ul|ol|pre|blockquote|address|p|h[1-6]|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary|li|tbody|tr|td|th|thead|tbody|tfoot|col|colgroup|caption|dt|dd)';
        $Text = preg_replace('!(?:<br\s*/>){1,2}\s*(<'.$allblocks.'[^>]*>)!', "\n$1", $Text);
        $Text = preg_replace('!(</'.$allblocks.'[^>]*>)\s*(?:<br\s*/>){1,2}!', "$1\n", $Text);
        return $Text;
    }
}

if (!function_exists('formatIP')) {
    /**
     * Format an IP address for display.
     *
     * @param string $IP An IP address to be formatted.
     * @param bool $html Format as HTML.
     * @return string Returns the formatted IP address.
     */
    function formatIP($IP, $html = true) {
        $result = '';

        // Is this a packed IP address?
        if (!filter_var($IP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4|FILTER_FLAG_IPV6) && $unpackedIP = @inet_ntop($IP)) {
            $IP = $unpackedIP;
        }

        if (filter_var($IP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $result = $html ? htmlspecialchars($IP) : $IP;
        } elseif (filter_var($IP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $result = $html ? wrap(t('IPv6'), 'span', ['title' => $IP]) : $IP;
        }

        return $result;
    }
}

if (!function_exists('formatPossessive')) {
    /**
     * Format a word using English "possessive" formatting.
     *
     * This can be overridden in language definition files like:
     *
     * ```
     * /applications/garden/locale/en-US.php.
     * ```
     */
    function formatPossessive($Word) {
        if (function_exists('formatPossessiveCustom')) {
            return formatPossesiveCustom($Word);
        }

        return substr($Word, -1) == 's' ? $Word."'" : $Word."'s";
    }
}

if (!function_exists('formatRssCustom')) {
    /**
     * @param string $html
     * @return string Returns the filtered RSS.
     */
    function formatRssHtmlCustom($html) {
        return Htmlawed::filterRSS($html);
    }
}

if (!function_exists('formatUsername')) {
    /**
     *
     *
     * @param $User
     * @param $Format
     * @param bool $ViewingUserID
     * @return mixed|string
     */
    function formatUsername($User, $Format, $ViewingUserID = false) {
        if ($ViewingUserID === false) {
            $ViewingUserID = Gdn::session()->UserID;
        }
        $UserID = val('UserID', $User);
        $Name = val('Name', $User);
        $Gender = strtolower(val('Gender', $User));

        $UCFirst = substr($Format, 0, 1) == strtoupper(substr($Format, 0, 1));

        switch (strtolower($Format)) {
            case 'you':
                if ($ViewingUserID == $UserID) {
                    return t("Format $Format", $Format);
                }
                return $Name;
            case 'his':
            case 'her':
            case 'your':
                if ($ViewingUserID == $UserID) {
                    return t("Format Your", 'Your');
                } else {
                    switch ($Gender) {
                        case 'm':
                            $Format = 'his';
                            break;
                        case 'f':
                            $Format = 'her';
                            break;
                        default:
                            $Format = 'their';
                            break;
                    }
                    if ($UCFirst) {
                        $Format = ucfirst($Format);
                    }
                    return t("Format $Format", $Format);
                }
                break;
            default:
                return $Name;
        }
    }
}

if (!function_exists('hasEditProfile')) {
    /**
     * Determine whether or not a given user has the edit profile link.
     *
     * @param int $userID The user ID to check.
     * @return bool Return true if the user should have the edit profile link or false otherwise.
     */
    function hasEditProfile($userID) {
        if (checkPermission(['Garden.Users.Edit', 'Moderation.Profiles.Edit'])) {
            return true;
        }
        if ($userID != Gdn::session()->UserID) {
            return false;
        }

        $result = checkPermission('Garden.Profiles.Edit') && c('Garden.UserAccount.AllowEdit');

        $result = $result && (
            c('Garden.Profile.Titles') ||
            c('Garden.Profile.Locations', false) ||
            c('Garden.Registration.Method') != 'Connect'
        );

        return $result;
    }
}

if (!function_exists('hoverHelp')) {
    /**
     * Add span with hover text to a string.
     *
     * @param string $String
     * @param string $Help
     * @return string
     */
    function hoverHelp($String, $Help) {
        return wrap($String.wrap($Help, 'span', ['class' => 'Help']), 'span', ['class' => 'HoverHelp']);
    }
}

if (!function_exists('img')) {
    /**
     * Returns an img tag.
     *
     * @param string $Image
     * @param string $Attributes
     * @param bool|false $WithDomain
     * @return string
     */
    function img($Image, $Attributes = '', $WithDomain = false) {
        if ($Attributes != '') {
            $Attributes = attribute($Attributes);
        }

        if (!isUrl($Image)) {
            $Image = smartAsset($Image, $WithDomain);
        }

        return '<img src="'.htmlspecialchars($Image, ENT_QUOTES).'"'.$Attributes.' />';
    }
}

if (!function_exists('inCategory')) {
    /**
     * Return whether or not the page is in a given category.
     *
     * @param string $Category The url code of the category.
     * @return boolean
     * @since 2.1
     */
    function inCategory($Category) {
        $Breadcrumbs = (array)Gdn::controller()->data('Breadcrumbs', []);

        foreach ($Breadcrumbs as $Breadcrumb) {
            if (isset($Breadcrumb['CategoryID']) && strcasecmp($Breadcrumb['UrlCode'], $Category) == 0) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('inSection')) {
    /**
     * Returns whether or not the page is in one of the given section(s).
     *
     * @param string|array $Section
     * @return bool
     * @since 2.1
     */
    function inSection($Section) {
        return Gdn_Theme::inSection($Section);
    }
}

if (!function_exists('ipAnchor')) {
    /**
     * Returns an IP address with a link to the user search.
     *
     * @param string $IP
     * @param string $CssClass
     * @return string
     */
    function ipAnchor($IP, $CssClass = '') {
        if ($IP) {
            return anchor(formatIP($IP), '/user/browse?keywords='.urlencode(ipDecode($IP)), $CssClass);
        } else {
            return $IP;
        }
    }
}

if (!function_exists('panelHeading')) {
    /**
     * Define default head tag for the side panel.
     *
     * @param string $content The content of the tag.
     * @param string $attributes The attributes of the tag.
     * @return string The full tag.
     */
    function panelHeading($content, $attributes = '') {
        return wrap($content, 'h4', $attributes);
    }
}

if (!function_exists('plural')) {
    /**
     * Return the plural version of a word depending on a number.
     *
     * This can be overridden in language definition files like:
     *
     * ```
     * /applications/garden/locale/en-US/definitions.php.
     * ```
     *
     * @param $Number
     * @param $Singular
     * @param $Plural
     * @param bool $FormattedNumber
     * @return string
     */
    function plural($Number, $Singular, $Plural, $FormattedNumber = false) {
        // Make sure to fix comma-formatted numbers
        $WorkingNumber = str_replace(',', '', $Number);
        if ($FormattedNumber === false) {
            $FormattedNumber = $Number;
        }

        $Format = t(abs($WorkingNumber) == 1 ? $Singular : $Plural);

        return sprintf($Format, $FormattedNumber);
    }
}

if (!function_exists('pluralTranslate')) {
    /**
     * Translate a plural string.
     *
     * @param int $Number
     * @param string $Singular
     * @param string $Plural
     * @param string|bool $SingularDefault
     * @param string|bool $PluralDefault
     * @return string
     * @since 2.1
     */
    function pluralTranslate($Number, $Singular, $Plural, $SingularDefault = false, $PluralDefault = false) {
        if ($Number == 1) {
            return t($Singular, $SingularDefault);
        } else {
            return t($Plural, $PluralDefault);
        }
    }
}

if (!function_exists('searchExcerpt')) {
    /**
     * Excerpt a search result.
     *
     * @param string $PlainText
     * @param array|string $SearchTerms
     * @param int $Length
     * @param bool $Mark
     * @return string
     */
    function searchExcerpt($PlainText, $SearchTerms, $Length = 200, $Mark = true) {
        if (empty($SearchTerms)) {
            return substrWord($PlainText, 0, $Length);
        }

        if (is_string($SearchTerms)) {
            $SearchTerms = preg_split('`[\s|-]+`i', $SearchTerms);
        }

        // Split the string into lines.
        $Lines = explode("\n", $PlainText);
        // Find the first line that includes a search term.
        foreach ($Lines as $i => &$Line) {
            $Line = trim($Line);
            if (!$Line) {
                continue;
            }

            foreach ($SearchTerms as $Term) {
                if (!$Term) {
                    continue;
                }

                if (($Pos = mb_stripos($Line, $Term)) !== false) {
                    $Line = substrWord($Line, $Term, $Length);

                    if ($Mark) {
                        return markString($SearchTerms, $Line);
                    } else {
                        return $Line;
                    }
                }
            }
        }

        // No line was found so return the first non-blank line.
        foreach ($Lines as $Line) {
            if ($Line) {
                return sliceString($Line, $Length);
            }
        }
        return '';
    }

    /**
     *
     *
     * @param int $str
     * @param int $start
     * @param int $length
     * @return string
     */
    function substrWord($str, $start, $length) {
        // If we are offsetting on a word then find it.
        if (is_string($start)) {
            $pos = mb_stripos($str, $start);
            if ($pos !== false && (($pos + strlen($start)) <= $length)) {
                $start = 0;
            } else {
                $start = $pos - $length / 4;
            }
        }

        // Find the word break from the offset.
        if ($start > 0) {
            $pos = mb_strpos($str, ' ', $start);
            if ($pos !== false) {
                $start = $pos;
            }
        } elseif ($start < 0) {
            $pos = mb_strrpos($str, ' ', $start);
            if ($pos !== false) {
                $start = $pos;
            } else {
                $start = 0;
            }
        }

        $len = strlen($str);

        if ($start + $length > $len) {
            if ($length - $start <= 0) {
                $start = 0;
            } else {
                // Zoom the offset back a bit.
                $pos = mb_strpos($str, ' ', max(0, $len - $length));
                if ($pos === false) {
                    $pos = $len - $length;
                }
            }
        }

        $result = mb_substr($str, $start, $length);
        return $result;
    }
}

if (!function_exists('userAnchor')) {
    /**
     * Take a user object, and writes out an anchor of the user's name to the user's profile.
     *
     * @param array|object $User
     * @param null $CssClass
     * @param null $Options
     * @return string
     */
    function userAnchor($User, $CssClass = null, $Options = null) {
        static $NameUnique = null;
        if ($NameUnique === null) {
            $NameUnique = c('Garden.Registration.NameUnique');
        }

        if (is_array($CssClass)) {
            $Options = $CssClass;
            $CssClass = null;
        } elseif (is_string($Options)) {
            $Options = ['Px' => $Options];
        }

        $Px = val('Px', $Options, '');
        $Name = val($Px.'Name', $User, t('Unknown'));
        $Text = val('Text', $Options, htmlspecialchars($Name)); // Allow anchor text to be overridden.

        $Attributes = [
            'class' => $CssClass,
            'rel' => val('Rel', $Options)
        ];
        if (isset($Options['title'])) {
            $Attributes['title'] = $Options['title'];
        }

        $UserUrl = userUrl($User, $Px);

        return '<a href="'.htmlspecialchars(url($UserUrl)).'"'.attribute($Attributes).'>'.$Text.'</a>';
    }
}

if (!function_exists('userBuilder')) {
    /**
     * Take an object & prefix value and convert it to a user object that can be used by UserAnchor() && UserPhoto().
     *
     * The object must have the following fields: UserID, Name, Photo.
     *
     * @param stdClass|array $row The row with the user extract.
     * @param string|array $userPrefix Either a single string user prefix or an array of prefix searches.
     * @return stdClass Returns an object containing the user.
     */
    function userBuilder($row, $userPrefix = '') {
        $row = (object)$row;
        $user = new stdClass();

        if (is_array($userPrefix)) {
            // Look for the first user that has the desired prefix.
            foreach ($userPrefix as $px) {
                if (property_exists($row, $px.'Name')) {
                    $userPrefix = $px;
                    break;
                }
            }

            if (is_array($userPrefix)) {
                $userPrefix = '';
            }
        }

        $userID = $userPrefix.'UserID';
        $name = $userPrefix.'Name';
        $photo = $userPrefix.'Photo';
        $gender = $userPrefix.'Gender';


        $user->UserID = $row->$userID;
        $user->Name = $row->$name;
        $user->Photo = property_exists($row, $photo) ? $row->$photo : '';
        $user->Email = val($userPrefix.'Email', $row, null);
        $user->Gender = property_exists($row, $gender) ? $row->$gender : null;

        return $user;
    }
}

if (!function_exists('userPhoto')) {
    /**
     * Takes a user object, and writes out an anchor of the user's icon to the user's profile.
     *
     * @param object|array $User A user object or array.
     * @param array $Options
     * @return string HTML.
     */
    function userPhoto($User, $Options = []) {
        if (is_string($Options)) {
            $Options = ['LinkClass' => $Options];
        }

        if ($Px = val('Px', $Options)) {
            $User = userBuilder($User, $Px);
        } else {
            $User = (object)$User;
        }

        $LinkClass = concatSep(' ', val('LinkClass', $Options, ''), 'PhotoWrap');
        $ImgClass = val('ImageClass', $Options, 'ProfilePhoto');

        $Size = val('Size', $Options);
        if ($Size) {
            $LinkClass .= " PhotoWrap{$Size}";
            $ImgClass .= " {$ImgClass}{$Size}";
        } else {
            $ImgClass .= " {$ImgClass}Medium"; // backwards compat
        }

        $FullUser = Gdn::userModel()->getID(val('UserID', $User), DATASET_TYPE_ARRAY);
        $UserCssClass = val('_CssClass', $FullUser);
        if ($UserCssClass) {
            $LinkClass .= ' '.$UserCssClass;
        }

        $LinkClass = $LinkClass == '' ? '' : ' class="'.$LinkClass.'"';

        $Photo = val('Photo', $FullUser, val('PhotoUrl', $User));
        $Name = val('Name', $FullUser);
        $Title = htmlspecialchars(val('Title', $Options, $Name));

        if ($FullUser && $FullUser['Banned']) {
            $Photo = c('Garden.BannedPhoto', 'https://images.v-cdn.net/banned_large.png');
            $Title .= ' ('.t('Banned').')';
        }

        if ($Photo) {
            if (!isUrl($Photo)) {
                $PhotoUrl = Gdn_Upload::url(changeBasename($Photo, 'n%s'));
            } else {
                $PhotoUrl = $Photo;
            }
        } else {
            $PhotoUrl = UserModel::getDefaultAvatarUrl($FullUser, 'thumbnail');
        }

        $href = (val('NoLink', $Options)) ? '' : ' href="'.url(userUrl($FullUser)).'"';

        return '<a title="'.$Title.'"'.$href.$LinkClass.'>'
                .img($PhotoUrl, ['alt' => $Name, 'class' => $ImgClass])
            .'</a>';
    }
}

if (!function_exists('userPhotoUrl')) {
    /**
     * Take a user object an return the URL to their photo.
     *
     * @param object|array $User
     * @return string
     */
    function userPhotoUrl($User) {
        $FullUser = Gdn::userModel()->getID(val('UserID', $User), DATASET_TYPE_ARRAY);
        $Photo = val('Photo', $User);
        if ($FullUser && $FullUser['Banned']) {
            $Photo = 'https://images.v-cdn.net/banned_100.png';
        }

        if ($Photo) {
            if (!isUrl($Photo)) {
                $PhotoUrl = Gdn_Upload::url(changeBasename($Photo, 'n%s'));
            } else {
                $PhotoUrl = $Photo;
            }
            return $PhotoUrl;
        }
        return UserModel::getDefaultAvatarUrl($User);
    }
}

if (!function_exists('userUrl')) {
    /**
     * Return the URL for a user.
     *
     * @param array|object $User The user to get the url for.
     * @param string $Px The prefix to apply before fieldnames.
     * @param string $Method Optional. ProfileController method to target.
     * @param array? $Get An optional query string array to add to the URL.
     * @return string The url suitable to be passed into the Url() function.
     * @since 2.1
     */
    function userUrl($User, $Px = '', $Method = '', $Get = null) {
        static $NameUnique = null;
        if ($NameUnique === null) {
            $NameUnique = c('Garden.Registration.NameUnique');
        }

        $UserName = val($Px.'Name', $User);
        // Make sure that the name will not be split if the p parameter is set.
        // Prevent p=/profile/a&b to be translated to $_GET['p'=>'/profile/a?', 'b'=>'']
        $UserName = str_replace(['/', '&'], ['%2f', '%26'], $UserName);

        $Result = '/profile/'.
            ($Method ? trim($Method, '/').'/' : '').
            ($NameUnique ? '' : val($Px.'UserID', $User, 0).'/').
            rawurlencode($UserName);

        if (!empty($Get)) {
            $Result .= '?'.http_build_query($Get);
        }

        return $Result;
    }
}

if (!function_exists('wrap')) {
    /**
     * Wrap the provided string in the specified tag.
     *
     * @example wrap('This is bold!', 'b');
     *
     * @param $String
     * @param string $Tag
     * @param string $Attributes
     * @return string
     */
    function wrap($String, $Tag = 'span', $Attributes = '') {
        if ($Tag == '') {
            return $String;
        }

        if (is_array($Attributes)) {
            $Attributes = attribute($Attributes);
        }

        // Strip the first part of the tag as the closing tag - this allows us to
        // easily throw 'span class="something"' into the $Tag field.
        $Space = strpos($Tag, ' ');
        $ClosingTag = $Space ? substr($Tag, 0, $Space) : $Tag;
        return '<'.$Tag.$Attributes.'>'.$String.'</'.$ClosingTag.'>';
    }
}

if (!function_exists('wrapIf')) {
    /**
     * Wrap the provided string if it isn't empty.
     *
     * @param string $String
     * @param string $Tag
     * @param array|string $Attributes
     * @return string
     * @since 2.1
     */
    function wrapIf($String, $Tag = 'span', $Attributes = '') {
        if (empty($String)) {
            return '';
        } else {
            return wrap($String, $Tag, $Attributes);
        }
    }
}

if (!function_exists('discussionLink')) {
    /**
     * Build URL for discussion.
     *
     * @deprecated discussionUrl()
     * @param $Discussion
     * @param bool $Extended
     * @return string
     */
    function discussionLink($Discussion, $Extended = true) {
        deprecated('discussionLink', 'discussionUrl');

        $DiscussionID = val('DiscussionID', $Discussion);
        $DiscussionName = val('Name', $Discussion);
        $Parts = [
            'discussion',
            $DiscussionID,
            Gdn_Format::url($DiscussionName)
        ];
        if ($Extended) {
            $Parts[] = ($Discussion->CountCommentWatch > 0) ? '#Item_'.$Discussion->CountCommentWatch : '';
        }
        return url(implode('/', $Parts), true);
    }
}

if (!function_exists('registerUrl')) {
    /**
     * Build URL for registration.
     *
     * @param string $Target
     * @param bool $force
     * @return string
     */
    function registerUrl($Target = '', $force = false) {
        $registrationMethod = strtolower(c('Garden.Registration.Method'));

        if ($registrationMethod === 'closed') {
            return '';
        }

        // Check to see if there is even a sign in button.
        if (!$force && $registrationMethod === 'connect') {
            $defaultProvider = Gdn_AuthenticationProviderModel::getDefault();
            if ($defaultProvider && !val('RegisterUrl', $defaultProvider)) {
                return '';
            }
        }

        return '/entry/register'.($Target ? '?Target='.urlencode($Target) : '');
    }
}

if (!function_exists('signInUrl')) {
    /**
     * Build URL for signin.
     *
     * @param string $target
     * @param bool $force
     * @return string
     */
    function signInUrl($target = '', $force = false) {
        // Check to see if there is even a sign in button.
        if (!$force && strcasecmp(c('Garden.Registration.Method'), 'Connect') !== 0) {
            $defaultProvider = Gdn_AuthenticationProviderModel::getDefault();
            if ($defaultProvider && !val('SignInUrl', $defaultProvider)) {
                return '';
            }
        }

        return '/entry/signin'.($target ? '?Target='.urlencode($target) : '');
    }
}

if (!function_exists('signOutUrl')) {
    /**
     * Build URL for signout.
     *
     * @param string $Target
     * @return string
     */
    function signOutUrl($Target = '') {
        if ($Target) {
            // Strip out the SSO from the target so that the user isn't signed back in again.
            $Parts = explode('?', $Target, 2);
            if (isset($Parts[1])) {
                parse_str($Parts[1], $Query);
                unset($Query['sso']);
                $Target = $Parts[0].'?'.http_build_query($Query);
            }
        }

        return '/entry/signout?TransientKey='.urlencode(Gdn::session()->transientKey()).($Target ? '&Target='.urlencode($Target) : '');
    }
}

if (!function_exists('socialSignInButton')) {
    /**
     * Build HTML for a social signin button.
     *
     * @param $Name
     * @param $Url
     * @param string $Type
     * @param array $Attributes
     * @return string HTML.
     */
    function socialSignInButton($Name, $Url, $Type = 'button', $Attributes = []) {
        touchValue('title', $Attributes, sprintf(t('Sign In with %s'), $Name));
        $Title = $Attributes['title'];
        $Class = val('class', $Attributes, '');
        unset($Attributes['class']);

        switch ($Type) {
            case 'icon':
                $Result = anchor(
                    '<span class="Icon"></span>',
                    $Url,
                    'SocialIcon SocialIcon-'.$Name.' '.$Class,
                    $Attributes
                );
                break;
            case 'button':
            default:
                $Result = anchor(
                    '<span class="Icon"></span><span class="Text">'.$Title.'</span>',
                    $Url,
                    'SocialIcon SocialIcon-'.$Name.' HasText '.$Class,
                    $Attributes
                );
                break;
        }

        return $Result;
    }
}

if (!function_exists('sprite')) {
    /**
     * Build HTML for a sprite.
     *
     * @param string $Name
     * @param string $Type
     * @param bool $Text
     * @return string
     */
    function sprite($Name, $Type = 'Sprite', $Text = false) {
        $Sprite = '<span class="'.$Type.' '.$Name.'"></span>';
        if ($Text) {
            $Sprite .= '<span class="sr-only">'.$Text.'</span>';
        }

        return $Sprite;
    }
}

if (!function_exists('hero')) {
    /**
     * A hero component is a stand-alone message on a page. It's great for "empty"-type messages, or to really draw
     * attention. It gets used in the (hidden) Vanilla Tutorial sections and in empty messages.
     *
     * @param string $title The title for the message.
     * @param string $body The message body.
     * @param array $buttonArray An array representing a button. Appears below the hero body.
     * Has the following properties:
     * ** 'text': The text to add on the button.
     * ** 'url': OPTIONAL The url to follow if the button is an anchor.
     * ** 'attributes': OPTIONAL The attributes on the button.
     * @param string $media An image or video to include in the hero.
     * @return string A string representing a hero component
     */
    function hero($title = '', $body = '', array $buttonArray = [], $media = '') {
        if ($title === '' && $body === '' && $media = '') {
            return '';
        }

        if (!empty($title)) {
            $title = wrap($title, 'div', ['class' => 'hero-title']);
        }

        if (!empty($body)) {
            $body = wrap($body, 'div', ['class' => 'hero-body']);
        }

        if (!empty($media)) {
            $media = wrap($media, 'div', ['class' => 'hero-media-wrapper']);
        }

        if (!empty($buttonArray)) {
            if (!isset($buttonArray['attributes']['class'])) {
                $buttonArray['attributes']['class'] = 'btn btn-secondary';
            }

            if (isset($buttonArray['url'])) {
                $button = anchor(val('text', $buttonArray), val('url', $buttonArray), '', val('attributes', $buttonArray));
            } else {
                $button = wrap(val('text', $buttonArray), 'button', val('attributes', $buttonArray));
            }
        } else {
            $button = '';
        }

        $content = wrap($title.$body.$button, 'div', ['class' => 'hero-content']);
        return wrap($content.$media, 'div', ['class' => 'hero']);
    }
}

if (!function_exists('writeReactions')) {
    /**
     * Write the HTML for a reaction button.
     *
     * @param $Row
     */
    function writeReactions($Row) {
        $Attributes = val('Attributes', $Row);
        if (is_string($Attributes)) {
            $Attributes = dbdecode($Attributes);
            setValue('Attributes', $Row, $Attributes);
        }

        Gdn::controller()->EventArguments['ReactionTypes'] = [];

        if ($ID = val('CommentID', $Row)) {
            $RecordType = 'comment';
        } elseif ($ID = val('ActivityID', $Row)) {
            $RecordType = 'activity';
        } else {
            $RecordType = 'discussion';
            $ID = val('DiscussionID', $Row);
        }
        Gdn::controller()->EventArguments['RecordType'] = $RecordType;
        Gdn::controller()->EventArguments['RecordID'] = $ID;

        echo '<div class="Reactions">';
        Gdn_Theme::bulletRow();

        // Write the flags.
        static $Flags = null;
        if ($Flags === null) {
            Gdn::controller()->EventArguments['Flags'] = &$Flags;
            Gdn::controller()->fireEvent('Flags');
        }

        // Allow addons to work with flags
        Gdn::controller()->EventArguments['Flags'] = &$Flags;
        Gdn::controller()->fireEvent('BeforeFlag');

        if (!empty($Flags) && is_array($Flags)) {
            echo Gdn_Theme::bulletItem('Flags');

            echo ' <span class="FlagMenu ToggleFlyout">';
            // Write the handle.
            echo anchor(sprite('ReactFlag', 'ReactSprite').' '.wrap(t('Flag'), 'span', ['class' => 'ReactLabel']), '', 'Hijack ReactButton-Flag FlyoutButton', ['title' => t('Flag')], true);
            echo sprite('SpFlyoutHandle', 'Arrow');
            echo '<ul class="Flyout MenuItems Flags" style="display: none;">';
            foreach ($Flags as $Flag) {
                if (is_callable($Flag)) {
                    echo '<li>'.call_user_func($Flag, $Row, $RecordType, $ID).'</li>';
                } else {
                    echo '<li>'.reactionButton($Row, $Flag['UrlCode']).'</li>';
                }
            }
            Gdn::controller()->fireEvent('AfterFlagOptions');
            echo '</ul>';
            echo '</span> ';
        }

        Gdn::controller()->fireEvent('AfterFlag');

        Gdn::controller()->fireEvent('AfterReactions');
        echo '</div>';
        Gdn::controller()->fireEvent('Replies');
    }
}
