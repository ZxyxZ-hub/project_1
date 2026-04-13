<?php
// ...existing code...
?>
<style>
    /* Layout + reset (inline) */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; }

    /* Center everything vertically/horizontally */
    body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #21aef5ff 0%, #3eb9f7ff 100%);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 30px;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Title */
    h1 {
        color: #ffffff;
        font-size: 2.2rem;
        text-align: center;
        margin-bottom: 1.25rem;
        text-shadow: 0 6px 18px rgba(0,0,0,0.25);
        letter-spacing: 0.4px;
    }

    /* Floating "form" style applied to the existing link */
    a.get-started {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-width: 220px;
        padding: 16px 28px;
        background: linear-gradient(180deg, #ffffff 0%, #f7f7f9 100%);
        color: #2b2b2b;
        text-decoration: none;
        font-weight: 700;
        border-radius: 14px;
        box-shadow: 0 18px 40px rgba(0,0,0,0.20), inset 0 -1px 0 rgba(0,0,0,0.03);
        transition: transform 220ms cubic-bezier(.2,.9,.2,1), box-shadow 220ms ease, filter 220ms ease;
        transform: translateY(0);
        position: relative;
        z-index: 10;
        cursor: pointer;
        border: 0;
    }

    /* Floating animation */
    @keyframes floatY {
        0%   { transform: translateY(0); }
        50%  { transform: translateY(-8px); }
        100% { transform: translateY(0); }
    }
    a.get-started {
        animation: floatY 3.6s ease-in-out infinite;
    }

    /* Hover / focus states for interactivity and accessibility */
    a.get-started:hover,
    a.get-started:focus {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 28px 60px rgba(0,0,0,0.28);
        filter: brightness(1.02);
        outline: none;
    }

    a.get-started:focus-visible {
        box-shadow: 0 28px 60px rgba(0,0,0,0.28), 0 0 0 4px rgba(102,126,234,0.15);
    }

    /* Small decorative chevron using pseudo-element */
    a.get-started::after {
        content: "→";
        font-size: 1.05rem;
        opacity: 0.95;
        transition: transform 220ms ease, opacity 220ms ease;
        margin-left: 6px;
        transform: translateX(0);
    }
    a.get-started:hover::after {
        transform: translateX(6px);
        opacity: 1;
    }

    /* Responsive tweaks */
    @media (max-width: 480px) {
        h1 { font-size: 1.6rem; margin-bottom: 0.9rem; }
        a.get-started { min-width: 180px; padding: 14px 20px; border-radius: 12px; }
    }
</style>

<h1>ORD Form System</h1>
    <a class="get-started" href="form">Get Started</a>