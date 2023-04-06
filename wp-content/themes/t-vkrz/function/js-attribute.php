<?php 

function add_type_attribute($tag, $handle, $src)
{
  if ('contenders-ajax' !== $handle) return $tag;

  $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
  return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute', 10, 3);

function add_type_attribute2($tag, $handle, $src)
{
  if ('get_notifications_page' !== $handle) return $tag;
  $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
  
  return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute2', 10, 6);

function add_type_attribute3($tag, $handle, $src)
{
  if ('get_friends_page' !== $handle) return $tag;
  $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
  
  return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute3', 10, 6);

function add_type_attribute4($tag, $handle, $src)
{
  if ('get_menuuser_notifications' !== $handle) return $tag;
  $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
  
  return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute4', 10, 6);

function add_type_attribute5($tag, $handle, $src)
{
  if ('follow_button' !== $handle) return $tag;
  $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
  
  return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute5', 10, 6);

function add_type_attribute6($tag, $handle, $src)
{
  if ('set_comment_notification' !== $handle) return $tag;
  $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
  
  return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute6', 10, 6);

function add_type_attribute7($tag, $handle, $src)
{
  if ('toplist_global' !== $handle) return $tag;
  $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
  
  return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute7', 10, 6);

function add_type_attribute8($tag, $handle, $src)
{
  if ('toplist' !== $handle) return $tag;
  $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
  
  return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute8', 10, 6);

function add_type_attribute9($tag, $handle, $src)
{
  if ('fetch_toplist_by_vainkeur' !== $handle) return $tag;
  $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
  
  return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute9', 10, 6);

function add_type_attribute10($tag, $handle, $src)
{
  if ('recherches' !== $handle) return $tag;
  $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
  
  return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute10', 10, 6);

function add_type_attribute12($tag, $handle, $src)
{
  if ('propositions' !== $handle) return $tag;
  $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
  
  return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute12', 10, 6);

function add_type_attribute13($tag, $handle, $src)
{
  if ('algo' !== $handle) return $tag;
  $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
  
  return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute13', 10, 6);