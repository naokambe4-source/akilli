#!/usr/bin/env python3
"""Generate colourful demo imagery for the Akıllı Creative demo content.

Usage: python3 -I tools/generate-demo-images.py <output-dir> <fonts-dir>
Everything is procedural: a lit satin height-field (numpy) and
"presentation board" compositions. No third-party photography.
"""
import os
import sys

import numpy as np
from PIL import Image, ImageDraw, ImageFilter, ImageFont

OUT, FONTS = sys.argv[1], sys.argv[2]
os.makedirs(OUT, exist_ok=True)

PAPER = (243, 239, 231)
INK = (21, 19, 15)


def font(name, size):
    return ImageFont.truetype(os.path.join(FONTS, name), size)


SERIF = 'instrument-serif-latin-400-normal.woff2'
SERIF_EXT = 'instrument-serif-latin-ext-400-normal.woff2'
SERIF_IT = 'instrument-serif-latin-400-italic.woff2'
SANS = 'hanken-grotesk-latin-wght-normal.woff2'


def text_font(size, italic=False):
    # Instrument Serif splits Turkish glyphs into latin-ext; Bodoni Moda variable covers both poorly,
    # so text containing ş/ğ/İ is drawn with the latin-ext file merged by falling back per glyph.
    return font(SERIF_IT if italic else SERIF, size)


def draw_tr(d, xy, txt, size, fill, italic=False):
    """Draw Turkish text by switching to the latin-ext subset for extended glyphs."""
    x, y = xy
    base = text_font(size, italic)
    ext = font(SERIF_EXT if not italic else 'instrument-serif-latin-ext-400-italic.woff2', size)
    for ch in txt:
        f = ext if ord(ch) > 0xFF and ch != 'ı' else base
        d.text((x, y), ch, font=f, fill=fill)
        x += d.textlength(ch, font=f)
    return x


def satin(w, h, tone, seed, light=(0.35, -0.55, 0.76), scale=1.0, contrast=1.0):
    """Lit satin drapery: long folds along one main direction, gently warped."""
    rng = np.random.default_rng(seed)
    y, x = np.mgrid[0:h, 0:w].astype(np.float32)
    x /= w
    y /= w
    main = rng.uniform(-0.5, 0.5) + 1.2
    hgt = np.zeros((h, w), np.float32)
    for i in range(4):
        a = main + rng.uniform(-0.22, 0.22)
        f = rng.uniform(0.45, 1.1) * scale * (1 + i * 0.7)
        ph = rng.uniform(0, 6.28)
        u = x * np.cos(a) + y * np.sin(a)
        v = -x * np.sin(a) + y * np.cos(a)
        warp = 0.28 * np.sin(v * rng.uniform(0.6, 1.6) * 6.28 + ph)
        hgt += np.sin(u * f * 6.28 + ph + warp * 3.0) / (1 + i * 1.4)
    gy, gx = np.gradient(hgt)
    k = 70.0 * contrast / max(scale, 0.5)
    nx, ny, nz = -gx * k, -gy * k, np.ones_like(hgt)
    n = np.sqrt(nx * nx + ny * ny + nz * nz)
    nx, ny, nz = nx / n, ny / n, nz / n
    lx, ly, lz = light
    ln = (lx * lx + ly * ly + lz * lz) ** 0.5
    lx, ly, lz = lx / ln, ly / ln, lz / ln
    diff = np.clip(nx * lx + ny * ly + nz * lz, 0, 1)
    hx, hy, hz = lx, ly, lz + 1
    hn = (hx * hx + hy * hy + hz * hz) ** 0.5
    spec = np.clip((nx * hx + ny * hy + nz * hz) / hn, 0, 1) ** 9
    shade = 0.55 + 0.5 * diff
    tone = np.array(tone, np.float32) / 255.0
    rgb = tone[None, None, :] * shade[..., None] + spec[..., None] * 0.26
    cx, cy = 0.5, 0.5 * h / w
    vign = 1 - 0.18 * (((x - cx) ** 2 + (y - cy) ** 2) ** 0.5)
    rgb *= vign[..., None]
    rgb = np.clip(rgb, 0, 1)
    img = Image.fromarray((rgb * 255).astype(np.uint8), 'RGB')
    return grain(img, seed, 0.014)


def grain(img, seed, amount=0.03):
    rng = np.random.default_rng(seed + 99)
    a = np.asarray(img).astype(np.float32) / 255.0
    noise = rng.normal(0, amount, a.shape[:2])[..., None]
    return Image.fromarray((np.clip(a + noise, 0, 1) * 255).astype(np.uint8), 'RGB')


def backdrop(w, h, tone, seed):
    """Seamless studio backdrop with a soft directional light falloff."""
    y, x = np.mgrid[0:h, 0:w].astype(np.float32)
    g = 1.04 - 0.22 * ((x / w - 0.25) ** 2 + (y / h - 0.1) ** 2) ** 0.5
    base = np.array(tone, np.float32) / 255.0
    rgb = np.clip(base[None, None, :] * g[..., None], 0, 1)
    return grain(Image.fromarray((rgb * 255).astype(np.uint8), 'RGB'), seed, 0.018)


def shadow(img, box, radius, blur, offset, strength=70):
    sh = Image.new('L', img.size, 0)
    x0, y0, x1, y1 = box
    ImageDraw.Draw(sh).rounded_rectangle([x0 + offset[0], y0 + offset[1], x1 + offset[0], y1 + offset[1]], radius=radius, fill=strength)
    sh = sh.filter(ImageFilter.GaussianBlur(blur))
    dark = Image.new('RGB', img.size, (24, 28, 60))
    img.paste(dark, (0, 0), sh)


def site_screen(w, h, brand, tagline, tone, accent, seed, mobile=False):
    """An understated website composition rendered with real typefaces."""
    scr = Image.new('RGB', (w, h), (250, 248, 244))
    d = ImageDraw.Draw(scr)
    pad = int(w * (0.07 if not mobile else 0.08))
    nav_y = int(h * (0.05 if not mobile else 0.04))
    small = font(SANS, max(10, int(w * (0.011 if not mobile else 0.036))))
    draw_tr(d, (pad, nav_y - 4), brand, int(w * (0.022 if not mobile else 0.07)), INK)
    if not mobile:
        small_ext = font('hanken-grotesk-latin-ext-wght-normal.woff2', small.size)
        for i, item in enumerate(['KOLEKSİYON', 'ATÖLYE', 'İLETİŞİM']):
            tx = w - pad - (3 - i) * int(w * 0.09)
            for ch in item:
                f = small_ext if ord(ch) > 0xFF else small
                d.text((tx, nav_y + 2), ch, font=f, fill=(90, 84, 74))
                tx += d.textlength(ch, font=f) + 1
    else:
        d.line([w - pad - 22, nav_y + 8, w - pad, nav_y + 8], fill=INK, width=2)
        d.line([w - pad - 22, nav_y + 16, w - pad, nav_y + 16], fill=INK, width=2)
    top = int(h * (0.15 if not mobile else 0.11))
    title_size = int(w * (0.055 if not mobile else 0.12))
    x = draw_tr(d, (pad, top), tagline[0], title_size, INK)
    draw_tr(d, (pad, top + int(title_size * 1.02)), tagline[1], title_size, INK, italic=True)
    img_top = top + int(title_size * 2.5)
    img_h = int(h * (0.52 if not mobile else 0.42))
    tex = satin(w - 2 * pad, img_h, tone, seed, scale=0.8 if not mobile else 0.6)
    scr.paste(tex, (pad, img_top))
    cap_y = img_top + img_h + int(h * 0.03)
    if cap_y < h - 30:
        d.text((pad, cap_y), '01 — SEZON', font=small, fill=(110, 102, 90))
        d.line([pad, cap_y + int(h * 0.05), w - pad, cap_y + int(h * 0.05)], fill=(205, 198, 186), width=1)
        d.rectangle([w - pad - int(w * 0.16), cap_y - 4, w - pad, cap_y + int(w * 0.026)], outline=INK, width=1)
    return scr


def project(name, brand, tagline, tone, back, seed):
    W, H = 2000, 1250
    img = backdrop(W, H, back, seed)
    sw, sh_ = 1260, 800
    sx, sy = 250, 210
    shadow(img, (sx, sy, sx + sw, sy + sh_), 4, 34, (26, 40), 85)
    img.paste(site_screen(sw, sh_, brand, tagline, tone, INK, seed), (sx, sy))
    ImageDraw.Draw(img).rectangle([sx, sy, sx + sw, sy + sh_], outline=(200, 192, 180), width=1)
    mw, mh = 330, 690
    mx, my = 1450, 390
    shadow(img, (mx, my, mx + mw, my + mh), 34, 30, (20, 34), 95)
    phone = Image.new('RGB', (mw, mh), (24, 22, 20))
    phone.paste(site_screen(mw - 20, mh - 20, brand, tagline, tone, INK, seed + 3, mobile=True), (10, 10))
    mask = Image.new('L', (mw, mh), 0)
    ImageDraw.Draw(mask).rounded_rectangle([0, 0, mw, mh], radius=40, fill=255)
    img.paste(phone, (mx, my), mask)
    img = img.resize((1600, 1000), Image.LANCZOS)
    img.save(os.path.join(OUT, name + '.jpg'), quality=86, optimize=True, progressive=True)
    # Detail 1: material study (satin swatch + type specimen).
    d1 = backdrop(1400, 1000, back, seed + 7)
    shadow(d1, (120, 140, 760, 860), 2, 26, (16, 26), 70)
    d1.paste(satin(640, 720, tone, seed + 8), (120, 140))
    dd = ImageDraw.Draw(d1)
    draw_tr(dd, (850, 230), 'Aa', 230, INK)
    draw_tr(dd, (850, 520), brand, 64, INK)
    draw_tr(dd, (850, 600), 'tipografi ve malzeme', 46, (95, 88, 78), italic=True)
    for i, c in enumerate([tone, INK, back, (250, 248, 244)]):
        dd.rectangle([850 + i * 110, 720, 940 + i * 110, 810], fill=c, outline=(190, 182, 170))
    d1.save(os.path.join(OUT, name + '-detay-1.jpg'), quality=84, optimize=True, progressive=True)
    # Detail 2: three mobile screens.
    d2 = backdrop(1400, 1000, back, seed + 11)
    for i in range(3):
        px, py = 200 + i * 360, 150 + (60 if i == 1 else 0)
        shadow(d2, (px, py, px + 300, py + 640), 34, 26, (16, 30), 85)
        ph = Image.new('RGB', (300, 640), (24, 22, 20))
        ph.paste(site_screen(282, 622, brand, tagline, tone, INK, seed + 20 + i, mobile=True), (9, 9))
        m = Image.new('L', (300, 640), 0)
        ImageDraw.Draw(m).rounded_rectangle([0, 0, 300, 640], radius=38, fill=255)
        d2.paste(ph, (px, py), m)
    d2.save(os.path.join(OUT, name + '-detay-2.jpg'), quality=84, optimize=True, progressive=True)


def plate(name, tone, seed, size=(1600, 900), light=(0.35, -0.55, 0.76), contrast=1.0):
    satin(size[0], size[1], tone, seed, light=light, contrast=contrast).save(os.path.join(OUT, name + '.jpg'), quality=84, optimize=True, progressive=True)


# Vivid, light palette matching the "Canlı" theme: saturated satin, pastel backdrops.
project('proje-hukuk', 'Örnek Hukuk', ('Hukukta', 'açıklık.'), (52, 72, 150), (208, 222, 255), 11)
project('proje-klinik', 'Örnek Klinik', ('Sakin bir', 'gülümseme.'), (44, 186, 164), (206, 244, 233), 22)
project('proje-moda', 'Örnek Atelier', ('Yeni sezon', 'koleksiyon.'), (255, 112, 80), (255, 222, 208), 33)
project('proje-b2b', 'Örnek Tedarik', ('Siparişten', 'sevkiyata.'), (250, 186, 40), (255, 239, 196), 44)
project('proje-otel', 'Örnek Konak', ('Taşın ve', 'denizin evi.'), (48, 146, 226), (212, 232, 252), 55)
project('proje-dernek', 'Örnek Vakıf', ('Birlikte', 'daha güçlü.'), (146, 104, 232), (232, 222, 253), 66)
plate('blog-web', (255, 128, 92), 101)
plate('blog-pos', (84, 124, 240), 102, light=(-0.4, -0.5, 0.8))
plate('blog-altyapi', (252, 186, 64), 103)
plate('blog-seo', (60, 192, 140), 104, light=(0.6, -0.3, 0.7))
plate('blog-logo', (36, 44, 96), 105, contrast=1.3)
plate('blog-saglik', (240, 140, 170), 106)
plate('studio-katmanlar', (255, 160, 128), 7, size=(1400, 1750))
plate('hero-saten', (255, 214, 196), 3, size=(2400, 1200), contrast=0.85)
print('ok')
