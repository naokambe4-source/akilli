#!/usr/bin/env python3
"""Generate abstract, clearly-labelled demo images for Akıllı Creative demo content.

Usage: python3 -I tools/generate-demo-images.py <output-dir> <font-ttf>
All artwork is generated procedurally (no third-party images).
"""
import sys, math, random, os
from PIL import Image, ImageDraw, ImageFilter, ImageFont

OUT = sys.argv[1]
FONT = sys.argv[2] if len(sys.argv) > 2 else None
os.makedirs(OUT, exist_ok=True)

PAPER = (247, 246, 242)
INK = (15, 20, 48)
INDIGO = (59, 70, 241)
PERI = (134, 152, 255)
CORAL = (255, 107, 61)

def hexrgb(h):
    h = h.lstrip('#'); return tuple(int(h[i:i+2], 16) for i in (0, 2, 4))

def font(size):
    try:
        return ImageFont.truetype(FONT, size)
    except Exception:
        return ImageFont.load_default()

def blobs(w, h, colors, seed, count=5, alpha=170):
    random.seed(seed)
    layer = Image.new('RGBA', (w, h), (0, 0, 0, 0))
    d = ImageDraw.Draw(layer)
    for i in range(count):
        c = colors[i % len(colors)]
        r = random.randint(int(w * .18), int(w * .38))
        x = random.randint(-r // 2, w - r // 2); y = random.randint(-r // 2, h - r // 2)
        d.ellipse([x, y, x + 2 * r, y + 2 * r], fill=c + (alpha,))
    return layer.filter(ImageFilter.GaussianBlur(w // 9))

def grain(img, amount=10, seed=1):
    random.seed(seed)
    noise = Image.effect_noise(img.size, amount).convert('L')
    return Image.blend(img.convert('RGB'), Image.merge('RGB', (noise, noise, noise)), 0.035)

def base(w, h, accent, seed):
    img = Image.new('RGBA', (w, h), PAPER + (255,))
    img.alpha_composite(blobs(w, h, [accent, PERI, CORAL, INDIGO], seed))
    return img

def label(d, w, h, text='ÖRNEK ÇALIŞMA'):
    f = font(int(h * .028))
    tw = d.textlength(text, font=f)
    pad = int(h * .02)
    x, y = w - tw - pad * 3, pad * 2
    d.rounded_rectangle([x - pad, y - pad // 2, x + tw + pad, y + int(h * .028) + pad], radius=99, fill=(255, 255, 255, 235))
    d.text((x, y), text, font=f, fill=INK)

def browser(img, box, accent, title, seed, mobile=False):
    random.seed(seed)
    d = ImageDraw.Draw(img)
    x0, y0, x1, y1 = box
    rad = 28 if not mobile else 46
    sh = Image.new('RGBA', img.size, (0, 0, 0, 0))
    ImageDraw.Draw(sh).rounded_rectangle([x0 + 10, y0 + 24, x1 + 10, y1 + 34], radius=rad, fill=(15, 20, 48, 60))
    img.alpha_composite(sh.filter(ImageFilter.GaussianBlur(28)))
    d.rounded_rectangle(box, radius=rad, fill=(255, 255, 255, 255))
    w = x1 - x0; h = y1 - y0
    if not mobile:
        for i, c in enumerate([(255, 95, 87), (254, 188, 46), (40, 200, 64)]):
            d.ellipse([x0 + 24 + i * 22, y0 + 20, x0 + 38 + i * 22, y0 + 34], fill=c)
        d.rounded_rectangle([x0 + 110, y0 + 16, x0 + w * .55, y0 + 38], radius=11, fill=(238, 238, 244))
        top = y0 + 56
    else:
        d.rounded_rectangle([x0 + w * .35, y0 + 14, x0 + w * .65, y0 + 30], radius=8, fill=(20, 20, 30))
        top = y0 + 46
    # hero band
    hb = Image.new('RGBA', (int(w - 40), int(h * .42)), accent + (255,))
    hb.alpha_composite(blobs(hb.width, hb.height, [PERI, CORAL, (255, 255, 255)], seed + 7, 4, 150))
    mask = Image.new('L', hb.size, 0); ImageDraw.Draw(mask).rounded_rectangle([0, 0, hb.width, hb.height], radius=18, fill=255)
    img.paste(hb, (int(x0 + 20), int(top)), mask)
    f = font(int(min(w * .055, 62)) if not mobile else int(w * .085))
    d.text((x0 + 48, top + hb.height * .32), title, font=f, fill=(255, 255, 255))
    d.rounded_rectangle([x0 + 48, top + hb.height * .68, x0 + 48 + w * .22, top + hb.height * .68 + 34], radius=17, fill=(255, 255, 255))
    # content rows
    y = top + hb.height + 26
    cols = 3 if not mobile else 1
    cw = (w - 40 - (cols - 1) * 16) / cols
    while y < y1 - 60:
        for c in range(cols):
            cx = x0 + 20 + c * (cw + 16)
            d.rounded_rectangle([cx, y, cx + cw, y + 90], radius=14, fill=(244, 244, 250))
            d.rounded_rectangle([cx + 16, y + 18, cx + 16 + cw * .5, y + 30], radius=6, fill=accent + (255,))
            d.rounded_rectangle([cx + 16, y + 44, cx + cw - 20, y + 54], radius=5, fill=(215, 217, 230))
            d.rounded_rectangle([cx + 16, y + 64, cx + cw * .7, y + 74], radius=5, fill=(215, 217, 230))
        y += 108

def project(name, accent_hex, title, seed):
    accent = hexrgb(accent_hex)
    W, H = 1600, 1000
    img = base(W, H, accent, seed)
    browser(img, (150, 130, 1230, 900), accent, title, seed)
    browser(img, (1150, 300, 1470, 940), accent, title.split(' ')[0], seed + 3, mobile=True)
    d = ImageDraw.Draw(img)
    grain(img, seed=seed).save(os.path.join(OUT, name + '.jpg'), quality=82, optimize=True, progressive=True)
    # detail 1: palette / type board
    W2, H2 = 1400, 1000
    b = base(W2, H2, accent, seed + 11); d = ImageDraw.Draw(b)
    sw = [accent, INK, PERI, (255, 255, 255), CORAL]
    for i, c in enumerate(sw):
        d.rounded_rectangle([120 + i * 236, 520, 320 + i * 236, 860], radius=26, fill=c + (255,), outline=(220, 220, 230), width=2)
    d.text((120, 160), 'Aa', font=font(220), fill=INK)
    d.text((520, 230), title, font=font(64), fill=INK)
    d.text((520, 320), 'Tasarım sistemi · renk ve tipografi', font=font(34), fill=(70, 76, 110))

    grain(b, seed=seed + 1).save(os.path.join(OUT, name + '-detay-1.jpg'), quality=80, optimize=True, progressive=True)
    # detail 2: mobile screens trio
    c = base(W2, H2, accent, seed + 21)
    for i in range(3):
        browser(c, (190 + i * 360, 120 + (i % 2) * 70, 500 + i * 360, 880 + (i % 2) * 70), accent, title.split(' ')[0], seed + 30 + i, mobile=True)

    grain(c, seed=seed + 2).save(os.path.join(OUT, name + '-detay-2.jpg'), quality=80, optimize=True, progressive=True)

def article(name, accent_hex, word, seed):
    accent = hexrgb(accent_hex)
    W, H = 1600, 900
    img = base(W, H, accent, seed)
    d = ImageDraw.Draw(img)
    random.seed(seed)
    for i in range(7):
        x = random.randint(80, W - 380); y = random.randint(80, H - 260)
        d.rounded_rectangle([x, y, x + random.randint(200, 360), y + random.randint(120, 220)], radius=30, outline=(255, 255, 255, 200), width=3)
    f = font(150)
    tw = d.textlength(word, font=f)
    d.text(((W - tw) / 2, H / 2 - 95), word, font=f, fill=INK)
    grain(img, seed=seed).save(os.path.join(OUT, name + '.jpg'), quality=80, optimize=True, progressive=True)

def studio(name, seed):
    W, H = 1400, 1050
    img = base(W, H, INDIGO, seed); d = ImageDraw.Draw(img)
    for i in range(4):
        x = 140 + i * 90; y = 160 + i * 110
        d.rounded_rectangle([x, y, x + 760, y + 470], radius=34, fill=(255, 255, 255, 120 + i * 30), outline=(255, 255, 255), width=2)
    d.text((560, 820), 'fikir → tasarım → kod', font=font(54), fill=INK)
    grain(img, seed=seed).save(os.path.join(OUT, name + '.jpg'), quality=82, optimize=True, progressive=True)

project('proje-hukuk', '#3b46f1', 'Hukuk Bürosu', 11)
project('proje-klinik', '#1fb5a5', 'Diş Kliniği', 22)
project('proje-moda', '#ff6b3d', 'Butik Moda', 33)
project('proje-b2b', '#6a5cff', 'B2B Sipariş', 44)
project('proje-otel', '#e0a400', 'Butik Otel', 55)
project('proje-dernek', '#e2467a', 'Dernek', 66)
article('blog-web', '#3b46f1', '8 soru', 101)
article('blog-pos', '#6a5cff', '3D Secure', 102)
article('blog-altyapi', '#ff6b3d', 'Paket · Woo · Özel', 103)
article('blog-seo', '#1fb5a5', 'Yerel SEO', 104)
article('blog-logo', '#e0a400', 'Logo ≠ Kimlik', 105)
article('blog-saglik', '#e2467a', 'Bilgilendir', 106)
studio('studio-katmanlar', 7)
print('ok')
