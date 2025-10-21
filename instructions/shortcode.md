# We are implementing something similar to wordpresses shortcode. But not quite the same.
- Our version of shortcode will be called codeblock

# What is a codeblock:
- It is a form of Embedded HTML code.
- Codeblocks are a block like all the others, but they have the ability to inject HTML, CSS, and JS into the page.
- The block setting will consist of a drop down for selecting (HTML, CSS, JS, Action)
- Codeblock has one more setting, content

(HTML) will render any html typed into the content
(CSS) will be loaded into that pages head
(JS) will be loaded into the body of the page.
(Action) Action only applies to any alerts in the page. So if the page features an alert we can add an action codeblock which will take the following parameters for triggering:
Trigger Object, which is the css class name or id of the button or form.
Alert Object, which will be the alert that is getting triggered.


