<?php
include('../include/admin_inc.php');
$objEvent=new admin;
$objEvent->genarateSiteMap();
$objEvent->next_record();


$date=date("Y-m-d h:i");
$string='<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="//kpasapp.com/kpasapp.xsl"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<sitemap>
<loc>http://kpasapp.com/staticpage.xml</loc>
<lastmod>2014-08-14T14:42:41+00:00</lastmod>
</sitemap>
<sitemap>
<loc>http://kpasapp.com/kpasapp_about.xml</loc>
<lastmod>2014-08-14T14:42:41+00:00</lastmod>
</sitemap>
<sitemap>
<loc>http://kpasapp.com/events.xml</loc>
<lastmod>2014-08-14T14:42:41+00:00</lastmod>
</sitemap>
<sitemap>
<loc>http://kpasapp.com/blogs.xml</loc>
<lastmod>2014-08-14T14:42:41+00:00</lastmod>
</sitemap>
</sitemapindex>
<!-- XML Sitemap generated by Yoast WordPress SEO -->
';


file_put_contents("../sitemap.xml", $string);


/*--------------------------kpasapp Static pages End-------------------------------------*/

$string_static='<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="//kpasapp.com/kpasapp.xsl"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1" xmlns:geo="http://www.google.com/geo/schemas/sitemap/1.0" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
  <url>
    <loc>http://kpasapp.com/en/home</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/home"/>
    <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/home"/>
  </url>
  <url>
    <loc>http://kpasapp.com/es/home</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/home"/>
     <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/home"/>
  </url>
  
    <url>
    <loc>http://kpasapp.com/en/about_kpasapp/</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/about_kpasapp/"/>
    <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/acerca_de_kpasapp/"/>
  </url>
  <url>
    <loc>http://kpasapp.com/es/acerca_de_kpasapp/</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/about_kpasapp/"/>
     <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/acerca_de_kpasapp/"/>
  </url> 

  
    <url>
    <loc>http://kpasapp.com/en/about-baja-sur/</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/about-baja-sur/"/>
    <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/acerca-de-baja-california-sur/"/>
  </url>
  <url>
    <loc>http://kpasapp.com/es/acerca-de-baja-california-sur</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/about-baja-sur/"/>
     <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/acerca-de-baja-california-sur/"/>
  </url> 

  
    <url>
    <loc>http://kpasapp.com/en/news/</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/news/"/>
    <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/news/"/>
  </url>
  <url>
    <loc>http://kpasapp.com/es/news/</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/news/"/>
     <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/news/"/>
  </url>
  
      <url>
    <loc>http://kpasapp.com/en/resources/</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/resources/"/>
    <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/resources/"/>
  </url>
  <url>
    <loc>http://kpasapp.com/es/resources/</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/resources/"/>
     <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/resources/"/>
  </url> 

</urlset>
';

file_put_contents("../staticpage.xml", $string_static);

/*--------------------------kpasapp Static pages End-------------------------------------*/

/*--------------------------kpasapp about sub pages-------------------------------------*/

$string_kpasapp_about='<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="//kpasapp.com/kpasapp.xsl"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1" xmlns:geo="http://www.google.com/geo/schemas/sitemap/1.0" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
  <url>
    <loc>http://kpasapp.com/en/about_kpasapp/feature</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/about_kpasapp/feature"/>
    <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/acerca_de_kpasapp/funciones"/>
  </url>
  <url>
    <loc>http://kpasapp.com/es/acerca_de_kpasapp/funciones</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/about_kpasapp/feature"/>
     <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/acerca_de_kpasapp/funciones"/>
  </url>
  
  <url>
    <loc>http://kpasapp.com/en/about_kpasapp/plan-pricing</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/about_kpasapp/plan-pricing"/>
    <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/acerca_de_kpasapp/planes-precios"/>
  </url>
  <url>
    <loc>http://kpasapp.com/es/acerca_de_kpasapp/planes-precios</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/about_kpasapp/plan-pricing"/>
     <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/acerca_de_kpasapp/planes-precios"/>
  </url>
  
  <url>
    <loc>http://kpasapp.com/en/about_kpasapp/event_goers</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/about_kpasapp/event_goers"/>
    <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/acerca_de_kpasapp/publico"/>
  </url>
  <url>
    <loc>http://kpasapp.com/es/acerca_de_kpasapp/publico</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/about_kpasapp/event_goers"/>
     <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/acerca_de_kpasapp/publico"/>
  </url>
  
  <url>
    <loc>http://kpasapp.com/en/about_kpasapp/event_professionals</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/about_kpasapp/event_professionals"/>
    <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/acerca_de_kpasapp/profesionales_de_eventos"/>
  </url>
  <url>
    <loc>http://kpasapp.com/es/acerca_de_kpasapp/profesionales_de_eventos</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/about_kpasapp/event_professionals"/>
     <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/acerca_de_kpasapp/profesionales_de_eventos"/>
  </url>
</urlset>
';


file_put_contents("../kpasapp_about.xml", $string_kpasapp_about);

/*--------------------------kpasapp about sub pages End-------------------------------------*/

/*--------------------------kpasapp Events pages Start-------------------------------------*/

$string1='<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="//kpasapp.com/kpasapp.xsl"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1" xmlns:geo="http://www.google.com/geo/schemas/sitemap/1.0" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
  <url>
    <loc>http://kpasapp.com/en/home</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/home"/>
    <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/home"/>
  </url>
   
  <url>
    <loc>http://kpasapp.com/es/home</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/home"/>
     <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/home"/>
  </url> 
</urlset>
';


file_put_contents("../events.xml", $string1);

/*--------------------------kpasapp Events pages End-------------------------------------*/

/*--------------------------kpasapp BLOG pages Start-------------------------------------*/

$string_blog='<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="//kpasapp.com/kpasapp.xsl"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1" xmlns:geo="http://www.google.com/geo/schemas/sitemap/1.0" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
  <url>
    <loc>http://kpasapp.com/en/blog/46/baja-sur-events-august-7-17-bisbee-in-los-barriles-culture-in-loreto-yoga-in-cabo</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/blog/46/baja-sur-events-august-7-17-bisbee-in-los-barriles-culture-in-loreto-yoga-in-cabo"/>
    <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/blog/46/baja-sur-eventos-7-17-de-augusto-bisbee-en-los-barriles-culture-en-loreto-yoga-en-cabo"/>
  </url>
   
  <url>
    <loc>http://kpasapp.com/es/blog/46/baja-sur-eventos-7-17-de-augusto-bisbee-en-los-barriles-culture-en-loreto-yoga-en-cabo</loc>
    <xhtml:link rel="alternate" hreflang="en" href="http://kpasapp.com/en/blog/46/baja-sur-events-august-7-17-bisbee-in-los-barriles-culture-in-loreto-yoga-in-cabo"/>
     <xhtml:link rel="alternate" hreflang="es" href="http://kpasapp.com/es/blog/46/baja-sur-eventos-7-17-de-augusto-bisbee-en-los-barriles-culture-en-loreto-yoga-en-cabo"/>
  </url> 
</urlset>
';


file_put_contents("../blogs.xml", $string_blog);

/*--------------------------kpasapp BLOG pages END-------------------------------------*/
echo "done";
?>