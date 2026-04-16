"""Gera as imagens OG do site IBK Maceió (1200x630)."""
from pathlib import Path
from PIL import Image, ImageDraw, ImageFont, ImageFilter

ROOT = Path(__file__).parent.parent
IMG_DIR = ROOT / "public" / "assets" / "img"
LOGO_PATH = ROOT / "public" / "assets" / "logo" / "logo-branco.png"
OUT_DIR = ROOT / "public" / "assets" / "og"
OUT_DIR.mkdir(parents=True, exist_ok=True)

W, H = 1200, 630

ACCENT = (232, 76, 30)  # #E84C1E
DARK_DEEP = (13, 13, 13)  # #0d0d0d
WHITE = (255, 255, 255)
WHITE_70 = (255, 255, 255, 180)

HELVETICA = "/System/Library/Fonts/HelveticaNeue.ttc"
HELVETICA_SUP = "/System/Library/Fonts/Supplemental/Helvetica.ttc"


def font(size, index=0):
    try:
        return ImageFont.truetype(HELVETICA, size, index=index)
    except Exception:
        return ImageFont.truetype(HELVETICA_SUP, size, index=index)


def load_bg(path: Path, target_w=W, target_h=H):
    """Abre, redimensiona preservando cover (como object-fit: cover)."""
    img = Image.open(path).convert("RGB")
    src_ratio = img.width / img.height
    tgt_ratio = target_w / target_h
    if src_ratio > tgt_ratio:
        new_h = target_h
        new_w = int(new_h * src_ratio)
    else:
        new_w = target_w
        new_h = int(new_w / src_ratio)
    img = img.resize((new_w, new_h), Image.LANCZOS)
    x = (new_w - target_w) // 2
    y = (new_h - target_h) // 2
    return img.crop((x, y, x + target_w, y + target_h))


def dark_overlay(img, from_alpha=140, to_alpha=230):
    """Aplica um gradiente escuro horizontal (mais escuro à direita)."""
    overlay = Image.new("RGBA", img.size, (0, 0, 0, 0))
    draw = ImageDraw.Draw(overlay)
    for x in range(img.size[0]):
        a = int(from_alpha + (to_alpha - from_alpha) * (x / img.size[0]))
        draw.line([(x, 0), (x, img.size[1])], fill=(13, 13, 13, a))
    base = img.convert("RGBA")
    return Image.alpha_composite(base, overlay)


def vertical_overlay(img, from_alpha=0, to_alpha=220):
    """Gradiente vertical — topo claro, base escura — para legibilidade."""
    overlay = Image.new("RGBA", img.size, (0, 0, 0, 0))
    draw = ImageDraw.Draw(overlay)
    for y in range(img.size[1]):
        a = int(from_alpha + (to_alpha - from_alpha) * (y / img.size[1]) ** 1.6)
        draw.line([(0, y), (img.size[0], y)], fill=(10, 10, 12, a))
    base = img.convert("RGBA")
    return Image.alpha_composite(base, overlay)


def paste_logo(canvas, max_h=56, pos=(64, 56)):
    logo = Image.open(LOGO_PATH).convert("RGBA")
    ratio = max_h / logo.height
    new_size = (int(logo.width * ratio), max_h)
    logo = logo.resize(new_size, Image.LANCZOS)
    canvas.paste(logo, pos, logo)


def draw_text(canvas, xy, text, fnt, fill=WHITE):
    draw = ImageDraw.Draw(canvas)
    draw.text(xy, text, font=fnt, fill=fill)


# ═════════════════════════════════════════════════════
# OG 1 — Default (compartilhar o site)
# ═════════════════════════════════════════════════════
def gen_og_default():
    bg = load_bg(IMG_DIR / "ibk-maceio-coral-ministerio-musica.webp")
    # Gradiente vertical: topo quase limpo (fachada visível), base escura (texto legível)
    canvas = vertical_overlay(bg, from_alpha=20, to_alpha=235)

    draw = ImageDraw.Draw(canvas)

    # Logo superior esquerdo
    paste_logo(canvas, max_h=54, pos=(64, 60))

    # ── Bloco de texto ancorado na base ──
    # Linha de acento laranja
    draw.rectangle([(64, 358), (108, 362)], fill=ACCENT)

    # Eyebrow
    eyebrow = font(19, index=1)  # Bold
    draw.text((124, 350), "IGREJA BATISTA KOINONIA · MACEIÓ, AL", font=eyebrow, fill=(255, 255, 255, 220))

    # Headline — duas linhas, bold enorme, sombra leve pra garantir legibilidade
    h1 = font(96, index=1)
    h1_italic = font(96, index=3)

    # Sombra: escreve 3px deslocado em preto translúcido
    def draw_with_shadow(xy, text, fnt, fill=WHITE):
        sx, sy = xy
        draw.text((sx + 2, sy + 3), text, font=fnt, fill=(0, 0, 0, 140))
        draw.text(xy, text, font=fnt, fill=fill)

    draw_with_shadow((62, 386), "Você foi feito", h1)
    draw_with_shadow((62, 492), "para ", h1)
    bbox = draw.textbbox((62, 492), "para ", font=h1)
    x_italic = bbox[2]
    draw_with_shadow((x_italic, 492), "pertencer.", h1_italic, fill=(255, 255, 255, 245))

    # ── Rodapé ──
    # Linha fina laranja acima do URL
    draw.rectangle([(64, 590), (120, 592)], fill=ACCENT)
    url_font = font(20, index=1)
    draw.text((64, 600), "ibkmaceio.com.br", font=url_font, fill=WHITE)

    # Canto direito inferior: texto "descubra +"
    right_font = font(18, index=2)
    right_text = "CONHEÇA NOSSA FAMÍLIA"
    right_bbox = draw.textbbox((0, 0), right_text, font=right_font)
    right_w = right_bbox[2] - right_bbox[0]
    draw.text((W - 64 - right_w, 602), right_text, font=right_font, fill=(255, 255, 255, 180))

    out = OUT_DIR / "og-default-v2.png"
    canvas.convert("RGB").save(out, "PNG", optimize=True)
    print(f"✓ {out.relative_to(ROOT)}")


# ═════════════════════════════════════════════════════
# OG 2 — Ao Vivo (compartilhar link da transmissão)
# ═════════════════════════════════════════════════════
def gen_og_live():
    # Fundo: foto da congregação com overlay bem escuro
    bg = load_bg(IMG_DIR / "ibk-maceio-auditorio-culto-congregacao.webp")
    # Blur leve para dar foco no texto
    bg = bg.filter(ImageFilter.GaussianBlur(radius=3))
    canvas = dark_overlay(bg, from_alpha=180, to_alpha=240)

    draw = ImageDraw.Draw(canvas)

    # Logo superior esquerdo
    paste_logo(canvas, max_h=52, pos=(64, 64))

    # Badge AO VIVO — pill vermelho com ponto branco
    badge_y = 238
    badge_h = 58
    dot_r = 9
    pill_padding_x = 26
    label = "AO VIVO"
    label_font = font(28, index=1)  # Bold
    label_bbox = draw.textbbox((0, 0), label, font=label_font)
    label_w = label_bbox[2] - label_bbox[0]
    pill_w = dot_r * 2 + 14 + label_w + pill_padding_x * 2
    pill_x = 64
    # Rounded pill
    draw.rounded_rectangle(
        [(pill_x, badge_y), (pill_x + pill_w, badge_y + badge_h)],
        radius=badge_h // 2,
        fill=ACCENT,
    )
    dot_cx = pill_x + pill_padding_x + dot_r
    dot_cy = badge_y + badge_h // 2
    draw.ellipse(
        [(dot_cx - dot_r, dot_cy - dot_r), (dot_cx + dot_r, dot_cy + dot_r)],
        fill=WHITE,
    )
    # Label
    label_x = dot_cx + dot_r + 14
    label_y = badge_y + (badge_h - (label_bbox[3] - label_bbox[1])) // 2 - label_bbox[1]
    draw.text((label_x, label_y), label, font=label_font, fill=WHITE)

    # Headline
    h1 = font(96, index=1)
    draw.text((62, 318), "Culto ao vivo agora", font=h1, fill=WHITE)

    # Subtítulo
    sub = font(30, index=0)
    draw.text(
        (64, 440),
        "Assista à transmissão da Igreja Batista Koinonia",
        font=sub,
        fill=(255, 255, 255, 220),
    )
    draw.text((64, 480), "Maceió · Alagoas", font=sub, fill=(255, 255, 255, 180))

    # Rodapé: URL com destaque
    url_font = font(22, index=1)
    draw.text((64, 556), "ibkmaceio.com.br/ao-vivo", font=url_font, fill=ACCENT)
    draw.rectangle([(W - 104, 564), (W - 64, 568)], fill=ACCENT)

    out = OUT_DIR / "og-ao-vivo.png"
    canvas.convert("RGB").save(out, "PNG", optimize=True)
    print(f"✓ {out.relative_to(ROOT)}")


if __name__ == "__main__":
    gen_og_default()
    gen_og_live()
