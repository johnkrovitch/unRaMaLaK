# Require any additional compass plugins here.

# Set this to the root of your project when deployed:
http_path = "web"
css_dir = "src/Krovitch/UnramalakBundle/Resources/public/css"
sass_dir = "src/Krovitch/UnramalakFrontBundle/Resources/sass"
images_dir = "src/Krovitch/UnramalakBundle/Resources/images"
javascripts_dir = "src/Krovitch/UnramalakBundle/Resources/public/js"

relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
line_comments = false
environment = :dev

if environment == :production
  output_style = :compressed
else
  output_style = :expanded
  sass_options = { :debug_info => true }
end