@include('front.components.services_data');
<?php

$output = "";
$i = 0;
foreach($services_data as $slug => $service) {
    $is_even = $i % 2 !== 0; // Alternating layout
    $i++;
    
    $row_class = $is_even ? ' flex-md-row-reverse' : '';
    $img_aos = $is_even ? 'fade-left' : 'fade-right';
    $text_aos = $is_even ? 'fade-right' : 'fade-left';
    
    $output .= '
            <!-- Service Block ' . $i . ' -->
            <div class="row align-items-center mb-5 pb-5' . $row_class . '">
                <div class="col-md-6 mb-4 mb-md-0" data-aos="' . $img_aos . '">
                    <img src="' . htmlspecialchars($service['image']) . '" class="w-100 shadow-sm" style="height: 500px; object-fit: cover;" alt="' . htmlspecialchars($service['title']) . '">
                </div>
                <div class="col-md-6 text-center px-md-5" data-aos="' . $text_aos . '">
                    <h2 class="ff-baskervville mb-3 text-custom-color-2" style="font-size: 2.2rem; font-style: italic;">' . htmlspecialchars($service['title']) . '</h2>
                    <p class="ff-gill-sans-light mb-4" style="font-size: 0.95rem; color: #555;">' . htmlspecialchars($service['subtitle']) . '</p>
                    
                    <div class="ff-gill-sans-light mb-5 text-start" style="font-size: 0.95rem; line-height: 1.8; color: #555;">
                        ' . $service['content'][0] . '
                    </div>
                    
                    <a href="service-detail.php?id=' . urlencode($slug) . '" class="btn btn-primary d-inline-block text-white text-decoration-none ff-gill-sans" style="background-color: var(--custom-color-2); padding: 0.8rem 2.5rem; letter-spacing: 2px; font-size: 0.85rem; border-radius: 0;">SEE MORE</a>
                </div>
            </div>';
}

echo $output;
?>
