import Link from "next/link";
import Image from "next/image";
import { MapPin, Heart } from "lucide-react";
import { CHURCH_INFO } from "@/lib/data/mock";

const FOOTER_LINKS = [
  {
    titulo: "A Igreja",
    links: [
      { label: "Quem Somos", href: "/sobre" },
      { label: "Nossa História", href: "/nossa-historia" },
      { label: "Lideranças", href: "/liderancas" },
      { label: "Ministérios", href: "/ministerios" },
      { label: "Programação", href: "/programacao" },
    ],
  },
  {
    titulo: "Conteúdo",
    links: [
      { label: "TV IBK", href: "/tv-ibk" },
      { label: "Podcasts", href: "/podcasts" },
      { label: "Galeria de Fotos", href: "/midia" },
      { label: "Novidades", href: "/novidades" },
      { label: "Eventos", href: "/eventos" },
    ],
  },
  {
    titulo: "Participe",
    links: [
      { label: "Seja Voluntário", href: "/voluntarios" },
      { label: "Dízimos e Ofertas", href: "/doacoes" },
      { label: "Fale Conosco", href: "/fale-conosco" },
      { label: "Ao Vivo", href: "/ao-vivo" },
    ],
  },
];

export default function Footer() {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="bg-[#1A1A1A] text-white">
      {/* Linha de acento laranja */}
      <div className="h-1 bg-[#D4521A]" />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12">
          {/* Brand */}
          <div className="lg:col-span-2">
            <Image
              src="/assets/logo/logo-branco.png"
              alt="IBK — Igreja Batista Koinonia"
              width={120}
              height={40}
              className="h-10 w-auto object-contain mb-4"
            />

            <p className="text-white/65 font-body text-sm leading-relaxed max-w-xs">
              Uma comunidade de fé em Maceió, Alagoas, comprometida com o amor
              a Deus e ao próximo.
            </p>

            <div className="flex items-center gap-2 mt-4 text-white/65 text-sm font-body">
              <MapPin size={14} className="text-[#D4521A] shrink-0" />
              <span>Maceió, Alagoas — Brasil</span>
            </div>

            <div className="flex gap-4 mt-6">
              <a
                href={CHURCH_INFO.instagram}
                target="_blank"
                rel="noopener noreferrer"
                className="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 text-white/70 hover:bg-[#D4521A] hover:text-white transition-all"
                aria-label="Instagram IBK"
              >
                {/* Instagram SVG */}
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                  <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                  <circle cx="12" cy="12" r="4"/>
                  <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                </svg>
              </a>
              <a
                href={CHURCH_INFO.youtube}
                target="_blank"
                rel="noopener noreferrer"
                className="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 text-white/70 hover:bg-[#D4521A] hover:text-white transition-all"
                aria-label="YouTube IBK"
              >
                {/* YouTube SVG */}
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                  <path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/>
                  <polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="currentColor" stroke="none"/>
                </svg>
              </a>
            </div>
          </div>

          {/* Links */}
          {FOOTER_LINKS.map((col) => (
            <div key={col.titulo}>
              <h4 className="font-display font-extrabold text-xs uppercase tracking-widest text-white/60 mb-4">
                {col.titulo}
              </h4>
              <ul className="space-y-1">
                {col.links.map((link) => (
                  <li key={link.href}>
                    <Link
                      href={link.href}
                      className="block py-2 text-sm text-white/65 hover:text-white font-body transition-colors"
                    >
                      {link.label}
                    </Link>
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </div>
      </div>

      {/* Bottom bar */}
      <div className="border-t border-white/10">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
          <p className="text-white/40 text-xs font-body">
            © {currentYear} Igreja Batista Koinonia — Maceió, AL
          </p>
          <p className="text-white/40 text-xs font-body flex items-center gap-1">
            Feito com <Heart size={10} className="text-[#D4521A]" /> em Maceió
          </p>
        </div>
      </div>
    </footer>
  );
}
