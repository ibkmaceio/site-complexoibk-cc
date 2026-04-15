// Dados mockados para a fase 1 — substituir por CMS na fase 2

export const CHURCH_INFO = {
  name: "Igreja Batista Koinonia",
  shortName: "IBK",
  tagline: "Somos Koinonia",
  city: "Maceió",
  state: "AL",
  country: "Brasil",
  address: "Maceió, Alagoas",
  coordinates: { lat: -9.6189476, lng: -35.7114562 },
  placeId: "0x701458b8d519f0f:0xcb5cd9a84a617430",
  pix: "30.382.392/0001-61",
  instagram: "https://instagram.com/ibkmaceio",
  youtube: "https://youtube.com/@ibkmaceio",
  whatsapp: "", // TODO: substituir pelo número real do cliente, ex: "https://wa.me/5582999999999"
  pastors: [
    { name: "Pr. Pedro Luz", role: "Pastor Titular" },
    { name: "Carla Luz", role: "Pastora" },
  ],
};

export const PROGRAMACAO = [
  {
    dia: "Domingo",
    cultos: [
      { horario: "9h00", nome: "Culto da Manhã" },
      { horario: "18h30", nome: "Culto da Noite" },
    ],
  },
  {
    dia: "Quarta-feira",
    cultos: [{ horario: "19h30", nome: "Culto de Oração" }],
  },
  {
    dia: "Sábado",
    cultos: [{ horario: "18h00", nome: "Culto de Jovens" }],
  },
];

export const VERSICULO = {
  texto:
    "Porque Deus tanto amou o mundo que deu o seu Filho unigênito, para que todo o que nele crer não pereça, mas tenha a vida eterna.",
  referencia: "João 3:16",
};

export const TEMA_MES = {
  mes: "Abril",
  titulo: "Foi por",
  destaque: "você",
  versiculo: "Pois Deus enviou o seu Filho ao mundo, não para condenar o mundo, mas para que este fosse salvo por meio dele.",
  referencia: "João 3:16-17",
  imagemBg: "/assets/img/tema-abril.webp",
};

// Datas das notícias: 2026 é o ano corrente do site. Cronologia intencional.
export const NOTICIAS = [
  {
    slug: "ibk-8-anos-culto-aniversario",
    titulo: "IBK celebra 8 anos com culto histórico em Maceió",
    resumo:
      "Uma noite marcada por adoração, gratidão e presença de Deus reuniu centenas de pessoas no culto de aniversário de 8 anos da Igreja Batista Koinonia.",
    imagem: "/assets/img/ibk-maceio-comunidade-fraternidade-8-anos.webp",
    data: "2026-03-04",
    autor: "IBK Maceió",
    tag: "Aniversário",
    destaque: true,
  },
  {
    slug: "ministerio-de-musica-ceia-do-senhor",
    titulo: "Ministério de música lidera louvor na Ceia do Senhor",
    resumo:
      "O coral da IBK conduziu um momento de profunda adoração durante o culto da Ceia do Senhor, reunindo toda a comunidade.",
    imagem: "/assets/img/ibk-maceio-coral-ministerio-musica.webp",
    data: "2025-08-03",
    autor: "IBK Maceió",
    tag: "Ministérios",
    destaque: false,
  },
  {
    slug: "culto-da-familia-koinonia",
    titulo: "Culto da Família reúne gerações em adoração",
    resumo:
      "O Culto da Família da IBK celebrou a fé compartilhada entre pais, filhos e jovens numa tarde de louvor e Palavra.",
    imagem: "/assets/img/ibk-maceio-louvor-culto-familia.webp",
    data: "2025-09-28",
    autor: "IBK Maceió",
    tag: "Família",
    destaque: false,
  },
  {
    slug: "comunidade-8-anos-fraternidade",
    titulo: "Comunidade IBK: 8 anos de fé e fraternidade",
    resumo:
      "Nos bastidores do aniversário, lideranças e membros se uniram em oração e gratidão pelos oito anos de história da Koinonia.",
    imagem: "/assets/img/ibk-maceio-comunidade-fraternidade-8-anos.webp",
    data: "2026-02-22",
    autor: "IBK Maceió",
    tag: "Comunidade",
    destaque: false,
  },
];


export const EVENTOS = [
  {
    titulo: "Culto de Páscoa 2025",
    data: "2025-04-20",
    horario: "18h30",
    local: "IBK Maceió",
    descricao: "Celebração especial de Páscoa com pregação e louvor.",
  },
  {
    titulo: "Conferência de Casais",
    data: "2025-05-10",
    horario: "19h00",
    local: "IBK Maceió",
    descricao: "Um final de semana dedicado ao fortalecimento do casamento.",
  },
  {
    titulo: "Retiro de Jovens",
    data: "2025-05-24",
    horario: "08h00",
    local: "Chácara Renovo",
    descricao: "Retiro anual dos jovens da IBK com pregação, louvor e integração.",
  },
];

export const DOACOES = {
  pix: "30.382.392/0001-61",
  bancos: [
    { banco: "Banco do Brasil", agencia: "1601-2", conta: "74423-9" },
    { banco: "Bradesco", agencia: "1597", conta: "80.000-7" },
    { banco: "Caixa", agencia: "0840", conta: "577571845-0" },
    { banco: "Santander", agencia: "3737", conta: "13006998-4" },
  ],
};
