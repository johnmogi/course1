<?php

namespace WCL;

use WCL\Access\Guard;
use WCL\Commerce\WooLink;
use WCL\PostTypes\Course;
use WCL\Ui\Blocks;
use WCL\Ui\Shortcodes;

class Plugin
{
    private static ?Plugin $instance = null;

    private ServiceContainer $container;

    private function __construct()
    {
        $this->container = new ServiceContainer();
        $this->register_services();
        $this->register_hooks();
    }

    public static function boot(): void
    {
        if (self::$instance instanceof self) {
            return;
        }

        self::$instance = new self();
    }

    public static function activate(): void
    {
        self::boot();
        flush_rewrite_rules();
    }

    public static function deactivate(): void
    {
        flush_rewrite_rules();
    }

    private function register_services(): void
    {
        $this->container->singleton(Course::class, static fn () => new Course());
        $this->container->singleton(Guard::class, static fn () => new Guard());
        $this->container->singleton(WooLink::class, function () {
            return new WooLink(
                $this->container->get(Guard::class)
            );
        });
        $this->container->singleton(Shortcodes::class, function () {
            return new Shortcodes(
                $this->container->get(Guard::class),
                $this->container->get(Course::class)
            );
        });
        $this->container->singleton(Blocks::class, function () {
            return new Blocks(
                $this->container->get(Guard::class)
            );
        });
    }

    private function register_hooks(): void
    {
        add_action('init', function () {
            $this->container->get(Course::class)->register();
        });

        add_action('init', function () {
            $this->container->get(Blocks::class)->register();
        });

        add_action('init', function () {
            $this->container->get(WooLink::class)->register();
        });

        add_action('init', function () {
            $this->container->get(Shortcodes::class)->register();
        });
    }
}
