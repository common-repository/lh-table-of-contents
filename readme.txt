=== LH Table of Contents ===
Contributors: shawfactor
Donate link: https://lhero.org/portfolio/lh-table-of-contents/
Tags: table of contents, toc, wiki like toc, semantic
Requires at least: 4.0
Tested up to: 5.2
Stable tag: trunk

create a wiki like TOC (table of contents) in your posts or pages using shortcode.

== Description ==

This plugin makes it easy to create a wiki like TOC (table of contents) in your posts or pages using shortcode, no linking or creating anchor is needed.

Unlike other plugins this is 100% semantic, ie drop the comment string: `<!-- lh_toc -->`.

Into your content body and the plugin will do the rest ie it will generate a table of contents based on the h2 and h3 tags in the content body.

If the comment is not included the table of contents is not generated.


= Features: =



== Installation ==

1. Upload the entire `lh-table-of-contents` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Include the string: <!-- lh_toc --> in the content body where you want the table of contents
1.  Done!

== Frequently Asked Questions ==

= How to style the TOC =

I left the styling up to you but the tabel of contents itself has a class of 'lh_table_of_contents', the anchors for h2 tags have a class of 'lh_toc-h2', and the anchors for h3 have a class of 'lh_toc-h3'.



== Changelog ==


**1.00 November 20, 2017**  
Initial release.

**1.05 November 25, 2017**  
Better approach to adding Toc.