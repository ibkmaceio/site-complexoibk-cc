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
  whatsapp: "",
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
  imagemBg: "/assets/img/tema-abril.jpg",
};

export const NOTICIAS = [
  {
    slug: "culto-de-pascoa-2025",
    titulo: "Culto de Páscoa reúne centenas na IBK",
    resumo:
      "Uma noite de adoração, pregação e comunhão marcou o Culto de Páscoa 2025 da Igreja Batista Koinonia.",
    imagem: "/assets/img/noticia-1.jpg",
    data: "2025-04-20",
    autor: "IBK Maceió",
    tag: "Eventos",
    destaque: true,
  },
  {
    slug: "novos-ministerios-2025",
    titulo: "IBK lança novos ministérios em 2025",
    resumo:
      "A igreja expande sua área de atuação com quatro novos ministérios voltados para a juventude e famílias.",
    imagem: "/assets/img/noticia-2.jpg",
    data: "2025-03-15",
    autor: "IBK Maceió",
    tag: "Ministérios",
    destaque: false,
  },
  {
    slug: "missao-alagoas-interior",
    titulo: "Missão no interior de Alagoas",
    resumo:
      "Equipe da IBK realiza ação missionária em cidades do interior alagoano com pregação e assistência social.",
    imagem: "/assets/img/noticia-3.jpg",
    data: "2025-02-28",
    autor: "IBK Maceió",
    tag: "Missões",
    destaque: false,
  },
  {
    slug: "ibk-8-anos-gratidao",
    titulo: "IBK celebra 8 anos com gratidão",
    resumo:
      "Comemorando oito anos de história, a IBK promoveu uma semana de celebração com cultos especiais.",
    imagem: "/assets/img/noticia-4.jpg",
    data: "2025-01-10",
    autor: "IBK Maceió",
    tag: "Aniversário",
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
