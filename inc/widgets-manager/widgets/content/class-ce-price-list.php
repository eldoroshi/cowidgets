<?php
/**
 * Elementor Classes.
 *
 * @package CoWidgets
 */

namespace COWIDGETS\WidgetsManager\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor Hudson Slider
 *
 * Elementor widget for Kiri Slider.
 *
 * @since 1.0.0
 */
class COWIDGETS_Price_List extends Widget_Base
{

    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return '';
    }
    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Price List', 'cowidgets');
    }
    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'ce-icon-packages';
    }
    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['ce-content-widgets'];
    }

    public function get_script_depends()
    {
        return ['ce-price-list'];
    }

    public function get_style_depends()
    {
        return ['ce-pricelist'];
    }
    /**
     * Register Copyright controls.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    { //phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
        $this->register_hudson_slider_controls();
    }
    /**
     * Register Copyright General Controls.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_hudson_slider_controls()
    {

        $this->start_controls_section(
            'section_content_other',
            [
                'label' => __('Main Content', 'cowidgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'my_option',
            [
                'label' => __('Monthly Yearly', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show Monthy Yearly', 'your-plugin'),
                'label_off' => __('Hide', 'your-plugin'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'cowidgets'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Choose your right <br> business plan',
                'condition' => [
                    'my_option' => ['yes'],
                ],
            ]
        );

        
        $this->add_control(
            'm_text',
            [
                'label' => __('Monthly Title', 'cowidgets'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Monthly',
                'condition' => [
                    'my_option' => ['yes'],
                ],
            ]
        );
        $this->add_control(
            'y_text',
            [
                'label' => __('Yearly Title', 'cowidgets'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Yearly',
                'condition' => [
                    'my_option' => ['yes'],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'package_section',
            [
                'label' => __('package', 'cowidgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'my_option' => [''],
                ],

            ]
        );
        $this->add_control(
            'mp_option',
            [
                'label' => __('Most Popular', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'your-plugin'),
                'label_off' => __('No', 'your-plugin'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        $this->add_control(
            'mp_title1',
            [
                'label' => __('Package Popular Title', 'cowidgets'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Most Popular',
                'condition' => [
                    'mp_option' => ['yes'],
                ],
            ]
        );

        $this->add_control(
            'package_title1',
            [
                'label' => __('Package Title', 'cowidgets'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Starup',
            ]

        );
        $this->add_control(
            'package_price1',
            [
                'label' => __('Pacckage Price', 'cowidgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '$49',
            ]
        );
        $this->add_control(
            'package_features',
            [
                'label' => __('Package Features', 'cowidgets'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Unlimited Bandwidth,Unlimited Storage,Mobile-Optimized Site,SL Security Certificates,Advanced Analytics',
            ]
        );
        $this->add_control(
            'package_btn_title1',
            [
                'label' => __('Button Title', 'cowidgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Buy Now', 'cowidgets'),
                'placeholder' => __('Type your title here', 'cowidgets'),
            ]
        );

        $this->add_control(
            'package_link1',
            [
                'label' => __('Link', 'cowidgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'cowidgets'),
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );
        $this->add_control(
            'hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->add_control(
            'secondpricelist',
            [
                'label' => __('Second Price List', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'plm_section',
            [
                'label' => __('Price List Monthy', 'cowidgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'my_option' => ['yes'],
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'mpm_option',
            [
                'label' => __('Most Popular', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'your-plugin'),
                'label_off' => __('No', 'your-plugin'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        $repeater->add_control(
            'packag2_title2',
            [
                'label' => __('Package Popular Title', 'cowidgets'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Most Popular',
                'condition' => [
                    'mpm_option' => ['yes'],
                ],
            ]
        );

        $repeater->add_control(
            'package_title2',
            [
                'label' => __('Package Title', 'cowidgets'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Business',
            ]
        );
        $repeater->add_control(
            'package_price2',
            [
                'label' => __('Pacckage Price', 'cowidgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '$59',
            ]
        );
        $repeater->add_control(
            'package_features2',
            [
                'label' => __('Package Features', 'cowidgets'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Unlimited Bandwidth , Unlimited Storage , Mobile-Optimized Site , SL Security Certificates , Advanced Analytics',
            ]
        );
        $repeater->add_control(
            'package_btn_title2',
            [
                'label' => __('Button Title', 'cowidgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Buy Now', 'cowidgets'),
                'placeholder' => __('Type your title here', 'cowidgets'),
            ]
        );

        $repeater->add_control(
            'package_link2',
            [
                'label' => __('Link', 'cowidgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'cowidgets'),
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );
        $this->add_control(
            'pricelist',
            [
                'label' => __('Price list', 'cowidgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [

                ],
                'title_field' => '{{{ package_title2 }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'ply_section',
            [
                'label' => __('Price List Yearly', 'cowidgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'my_option' => ['yes'],
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'mpy_option',
            [
                'label' => __('Most Popular', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'your-plugin'),
                'label_off' => __('No', 'your-plugin'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        $repeater->add_control(
            'packag2_title2',
            [
                'label' => __('Package Popular Title', 'cowidgets'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Most Popular',
                'condition' => [
                    'mpy_option' => ['yes'],
                ],
            ]
        );

        $repeater->add_control(
            'package_title2',
            [
                'label' => __('Package Title', 'cowidgets'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Business',
            ]
        );
        $repeater->add_control(
            'package_price2',
            [
                'label' => __('Pacckage Price', 'cowidgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '$59',
            ]
        );
        $repeater->add_control(
            'package_features2',
            [
                'label' => __('Package Features', 'cowidgets'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Unlimited Bandwidth , Unlimited Storage , Mobile-Optimized Site , SL Security Certificates , Advanced Analytics',
            ]
        );
        $repeater->add_control(
            'package_btn_title2',
            [
                'label' => __('Button Title', 'cowidgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Buy Now', 'cowidgets'),
                'placeholder' => __('Type your title here', 'cowidgets'),
            ]
        );

        $repeater->add_control(
            'package_link2',
            [
                'label' => __('Link', 'cowidgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'cowidgets'),
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );
        $this->add_control(
            'pricelist2',
            [
                'label' => __('Price list', 'cowidgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [

                ],
                'title_field' => '{{{ package_title2 }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_pricelist',
            [
                'label' => __('Price List Styles', 'cowidgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pltitle_typography',
                'label' => 'Price List title Typography',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .pricing-section .title ',
            ]
        );
        $this->add_control(
            'text_color',
            [
                'label' => __('Price List Title Color', 'cowidgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .pricing-section .title' => 'color: {{VALUE}}',
                ],

            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pllist_typography',
                'label' => 'Price List Typography',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .pricing-section .price-block .inner-box ul li',
            ]
        );
        $this->add_control(
            'list_color',
            [
                'label' => __('Price List Color', 'cowidgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .pricing-section .price-block .inner-box ul li' => 'color: {{VALUE}}',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'plmp_typography',
                'label' => 'Price List Most Popular Typography',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .pricing-section .price-block .inner-box .most-popular ',
            ]
        );
        $this->add_control(
            'ptextbg_color',
            [
                'label' => __('Price List Most Popular Background Color', 'cowidgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .pricing-section .price-block .inner-box .most-popular' => 'background-color: {{VALUE}}',
                ],

            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_pricelistbtn',
            [
                'label' => __('Button Styles', 'cowidgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'btn_line_color',
            [
                'label' => __('Button Border Color', 'cowidgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .pricing-section .price-block .inner-box .button-box .btn-style-nine' => 'border-color: {{VALUE}}',
                ],

            ]
        );
        $this->add_control(
            'btn_linetxt_color',
            [
                'label' => __('Button Text Color', 'cowidgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .pricing-section .price-block .inner-box .button-box .btn-style-nine' => 'color: {{VALUE}}',
                ],

            ]
        );
        $this->add_control(
            'btn_linebg_color',
            [
                'label' => __('Button Background Color', 'cowidgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pricing-section .price-block .inner-box .button-box .btn-style-nine' => 'background-color: {{VALUE}}',
                ],

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_pricelistbtnhover',
            [
                'label' => __('Button Hover Styles', 'cowidgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'btn_line_colorh',
            [
                'label' => __('Button Border Color', 'cowidgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .pricing-section .price-block .inner-box .button-box .btn-style-nine:hover' => 'border-color: {{VALUE}}',
                ],

            ]
        );
        $this->add_control(
            'btn_linetxt_colorh',
            [
                'label' => __('Button Text Color', 'cowidgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .pricing-section .price-block .inner-box .button-box .btn-style-nine:hover' => 'color: {{VALUE}}',
                ],

            ]
        );
        $this->add_control(
            'btn_linebg_colorh',
            [
                'label' => __('Button Background Color', 'cowidgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pricing-section .price-block .inner-box .button-box .btn-style-nine:hover' => 'background-color: {{VALUE}}',
                ],

            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render Copyright output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $target = $settings['link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';
        //print_r($settings);

        ?>

    <?php if ($settings['my_option'] == ""): ?>


		<div class="pricing-section pricing-section2">
		<!-- Price Block -->
		<div class="price-block ">
								<div class="inner-box">
								<?php if ($settings['mp_option'] == 'yes'): ?>
											<div class="most-popular"><?php echo esc_html($settings['mp_title1']); ?></div>
										<?php endif;?>
									<div class="title"><?php echo esc_html($settings['package_title1']); ?></div>
									<div class="price"><?php echo esc_html($settings['package_price1']); ?></div>
									<ul>
                                    <?php $features = explode(',', $settings['package_features']);?>
                                    <?php foreach ($features as $feature): ?>
                                        <li><?php echo esc_html($feature); ?></li>
                                    <?php endforeach;?>

									</ul>
									<div class="button-box text-center">
                                    <a href="<?php echo esc_url($service['package_link1']['url']) ?>" <?php echo esc_attr($target); ?> <?php echo esc_attr($nofollow); ?> class="theme-btn btn-style-nine"><?php echo esc_html($settings['package_btn_title1']) ?></a>

									</div>
								</div>
							</div>
		</div>




	<?php else: ?>
	<!-- Pricing Section -->
	<section class="pricing-section">
		<div class="auto-container">
			<!-- Sec Title -->


			<div class="pricing-tabs tabs-box">

				<!-- Title Column -->
				<div class="title-column">

					<!-- Tab Btns -->
					<ul class="tab-buttons clearfix">
						<li data-tab="#prod-monthly" class="tab-btn monthly active-btn"><?php echo wp_kses($settings['m_text'], array('br' => array())); ?></li>
						<li class="boll"><span class="round"></span></li>
						<li data-tab="#prod-yearly" class="tab-btn yearly"><?php echo wp_kses($settings['y_text'], array('br' => array())); ?></li>
					</ul>

				</div>

				<!--Tabs Container-->
				<div class="tabs-content">

					<!--Tab-->
					<div class="tab active-tab" id="prod-monthly">
						<div class="content">
							<div class="pattern-layer-one" style="background-image: url(images/icons/dotted-pattern-1.png)"></div>
							<div class="row clearfix">
								<?php $pricelists = $settings['pricelist'];?>
								<?php foreach ($pricelists as $pricelist): ?>
								<!-- Price Block -->
								<div class="price-block col-lg-4 col-md-6 col-sm-12">
									<div class="inner-box">
									<?php if ($pricelist['mpm_option'] == 'yes'): ?>
											<div class="most-popular"><?php echo esc_html($pricelist['packag2_title2']); ?></div>
										<?php endif;?>
									<div class="title"><?php echo esc_html($pricelist['package_title2']); ?></div>
									<div class="price"><?php echo esc_html($pricelist['package_price2']); ?></div>
									<ul>
                                    <?php $features = explode(',', $pricelist['package_features2']);?>
                                    <?php foreach ($features as $feature): ?>
                                        <li><?php echo esc_html($feature); ?></li>
                                    <?php endforeach;?>


									</ul>
									<div class="button-box text-center">
                                    <a href="<?php echo esc_url($pricelist['package_link2']['url']) ?>" <?php echo esc_attr($target); ?> <?php echo esc_attr($nofollow); ?> class="theme-btn btn-style-nine"><?php echo esc_html($pricelist['package_btn_title2']) ?></a>

									</div>
									</div>
								</div>
								<?php endforeach;?>


							</div>
						</div>
					</div>

					<!--Tab-->
					<div class="tab" id="prod-yearly">
						<div class="content">
							<div class="pattern-layer-one" style="background-image: url(images/icons/dotted-pattern-1.png)"></div>
							<div class="row clearfix">
							<?php $pricelists = $settings['pricelist2'];?>
								<?php foreach ($pricelists as $pricelist): ?>
									<div class="price-block col-lg-4 col-md-6 col-sm-12">
									<div class="inner-box">
									<?php if ($pricelist['mpy_option'] == 'yes'): ?>
											<div class="most-popular"><?php echo esc_html($pricelist['packag2_title2']); ?></div>
										<?php endif;?>
									<div class="title"><?php echo esc_html($pricelist['package_title2']); ?></div>
									<div class="price"><?php echo esc_html($pricelist['package_price2']); ?></div>
									<ul>
                                    <?php $features = explode(',', $pricelist['package_features2']);?>
                                    <?php foreach ($features as $feature): ?>
                                        <li><?php echo esc_html($feature); ?></li>
                                    <?php endforeach;?>


									</ul>
									<div class="button-box text-center">
                                    <a href="<?php echo esc_url($pricelist['package_link2']['url']) ?>" <?php echo esc_attr($target); ?> <?php echo esc_attr($nofollow); ?> class="theme-btn btn-style-nine"><?php echo esc_html($pricelist['package_btn_title2']) ?></a>

									</div>
									</div>
								</div>
								<?php endforeach;?>


							</div>
						</div>
					</div>

				</div>
				<!-- Support -->
				

			</div>

		</div>
	</section>
	<!-- End Pricing Section -->
	<?php endif;?>

		<?php
}

    /**
     * Render shortcode widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function content_template()
    {}

    /**
     * Render shortcode output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * Remove this after Elementor v3.3.0
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _content_template()
    {
        $this->content_template();
    }
}
