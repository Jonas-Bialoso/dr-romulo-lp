<?php
/**
 * Conteúdo inicial do seeder.
 *
 * GERADO AUTOMATICAMENTE a partir de index.html e liftera.html pelo script
 * scratchpad/gerar-seed.mjs. Não editar à mão: rode o script de novo se o
 * conteúdo estático mudar. Isso garante que o seed carregue exatamente o
 * texto validado contra o Figma.
 *
 * @package dr-romulo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'campanhas' => array(
		array(
			'slug' => 'preenchimento',
			'nome' => 'Retirada de preenchimento',
		),
		array(
			'slug' => 'liftera',
			'nome' => 'Liftera',
		),
	),
	'itens' => array(
		'drm_sinal' => array(
			'preenchimento' => array(
				array(
					'icone' => 'icon-sinal-deformidade.svg',
					'titulo' => 'Deformidade ou contorno alterado',
					'texto' => 'Áreas com volume onde não deveria haver, contornos irregulares ou um aspecto que não corresponde ao rosto que você reconhece.',
				),
				array(
					'icone' => 'icon-sinal-assimetria.svg',
					'titulo' => 'Assimetria',
					'texto' => 'Um lado visivelmente diferente do outro, seja em volume, em altura ou em projeção.',
				),
				array(
					'icone' => 'icon-sinal-inchaco.svg',
					'titulo' => 'Inchaço que não passa',
					'texto' => 'Edema persistente ou que aparece e some ao longo do tempo, às vezes meses ou anos depois da aplicação.',
				),
				array(
					'icone' => 'icon-sinal-vermelhidao.svg',
					'titulo' => 'Vermelhidão na região aplicada',
					'texto' => 'Alteração de cor que persiste, com ou sem calor local, sinal que sempre merece avaliação médica.',
				),
				array(
					'icone' => 'icon-sinal-nodulos.svg',
					'titulo' => 'Nódulos ou endurecimentos',
					'texto' => 'Caroços palpáveis, áreas endurecidas ou pontos que ficam evidentes em determinadas expressões.',
				),
				array(
					'icone' => 'icon-sinal-incomodo.svg',
					'titulo' => 'Incômodo constante',
					'texto' => 'A sensação de peso, de \'algo estranho\' ou o desconforto com a própria imagem no espelho, isso é motivo suficiente para procurar avaliação.',
				),
			),
			'liftera' => array(
				array(
					'imagem' => 'sinal-1.jpg',
					'escuro' => '',
					'titulo' => 'Papada',
					'texto' => 'Acúmulo e flacidez sob o queixo, que persistem mesmo quando o peso está estável.',
				),
				array(
					'imagem' => 'sinal-2.jpg',
					'escuro' => '',
					'titulo' => 'Contorno mandibular perdendo definição',
					'texto' => 'O famoso efeito buldogue: a linha da mandíbula deixa de ser reta e o tecido começa a acumular nas laterais do queixo.',
				),
				array(
					'imagem' => 'sinal-3.jpg',
					'escuro' => '',
					'titulo' => 'Sensação de derretimento facial',
					'texto' => 'O terço médio desce, as maçãs do rosto perdem projeção e o rosto parece mais pesado na parte de baixo.',
				),
				array(
					'imagem' => 'sinal-4.jpg',
					'escuro' => '',
					'titulo' => 'Pele mais mole ao toque',
					'texto' => 'Menos firmeza e menos elasticidade, especialmente nas bochechas e no pescoço.',
				),
				array(
					'imagem' => 'sinal-5.jpg',
					'escuro' => '',
					'titulo' => 'Sulcos mais marcados em repouso',
					'texto' => 'Linhas que antes só apareciam ao sorrir e agora permanecem quando o rosto está parado.',
				),
				array(
					'imagem' => 'sinal-6.jpg',
					'escuro' => '',
					'titulo' => 'Pescoço e colo com flacidez',
					'texto' => 'Pele mais fina e frouxa em uma região que costuma entregar a idade antes do rosto.',
				),
			),
		),
		'drm_beneficio' => array(
			'preenchimento' => array(
				array(
					'titulo' => 'Onde o produto realmente está',
					'texto' => 'O material aplicado migra, se acumula e nem sempre está onde foi injetado. O exame localiza a posição exata e a camada em que o produto se encontra.',
				),
				array(
					'titulo' => 'Que tipo de material está presente',
					'texto' => 'Ácido hialurônico, estimuladores de colágeno e outros biomateriais têm comportamentos distintos na imagem. A hialuronidase atua apenas sobre o ácido hialurônico.',
				),
				array(
					'titulo' => 'Se há inflamação ou nódulo',
					'texto' => 'O exame diferencia acúmulo de produto de processo inflamatório ou de tecido fibrosado ao redor do material, situações que pedem condutas diferentes.',
				),
				array(
					'titulo' => 'Onde estão os vasos',
					'texto' => 'A avaliação com Doppler mapeia as estruturas vasculares da região, informação essencial para a segurança de qualquer aplicação naquela área.',
				),
			),
			'liftera' => array(
				array(
					'imagem' => 'resultado-1.jpg',
					'escuro' => 'sim',
					'titulo' => 'Melhora da firmeza da pele',
					'texto' => 'Estímulo profundo que age diretamente na flacidez do rosto e do pescoço, devolvendo a densidade perdida.',
				),
				array(
					'imagem' => 'resultado-2.jpg',
					'escuro' => '',
					'titulo' => 'Definição da linha da mandíbula',
					'texto' => 'Tratamento focado no contorno facial para amenizar o aspecto de derretimento e redefinir os ângulos naturais.',
				),
				array(
					'imagem' => 'resultado-3.jpg',
					'escuro' => 'sim',
					'titulo' => 'Melhora do aspecto da papada',
					'texto' => 'Redução da flacidez e compactação da área sob o queixo, melhorando a linha do perfil.',
				),
				array(
					'imagem' => 'resultado-4.jpg',
					'escuro' => '',
					'titulo' => 'Sustentação do terço médio',
					'texto' => 'Efeito de ancoragem que eleva as maçãs do rosto e suaviza os sulcos ao redor da boca.',
				),
				array(
					'imagem' => 'resultado-5.jpg',
					'escuro' => '',
					'titulo' => 'Qualidade e textura da pele',
					'texto' => 'Estímulo contínuo de colágeno que resulta em uma pele visivelmente mais viçosa, firme e uniforme ao toque.',
				),
				array(
					'imagem' => 'resultado-6.jpg',
					'escuro' => '',
					'titulo' => 'Estratégia preventiva',
					'texto' => 'Gerenciamento inteligente do envelhecimento para retardar a evolução da flacidez antes que ela se acentue.',
				),
			),
		),
		'drm_mecanismo' => array(
			'liftera' => array(
				array(
					'titulo' => 'Energia focada, não superficial',
					'icone' => 'icon-liftera-energia.svg',
					'texto' => 'A energia atravessa a superfície da pele sem lesioná-la e se concentra apenas na profundidade programada. É por isso que o procedimento dispensa cortes e não exige afastamento das atividades.',
				),
				array(
					'titulo' => 'Camadas que sustentam o rosto',
					'icone' => 'icon-liftera-camadas.svg',
					'texto' => 'O aparelho permite trabalhar em diferentes profundidades, incluindo o plano onde estão as estruturas responsáveis pela sustentação facial, a mesma região que a cirurgia plástica traciona.',
				),
				array(
					'titulo' => 'Resultado construído pelo seu corpo',
					'icone' => 'icon-liftera-colageno.svg',
					'texto' => 'O que muda o aspecto da pele não é o aparelho: é o colágeno que o seu organismo produz em resposta ao estímulo. Por isso os efeitos são progressivos e aparecem ao longo de semanas, não no dia seguinte.',
				),
			),
		),
		'drm_etapa' => array(
			'preenchimento' => array(
				array(
					'titulo' => 'Consulta e história',
					'texto' => 'Entendimento do que foi aplicado, quando, em qual região e o que mudou desde então. Se você tiver notas fiscais, receituários ou o nome do produto, traga pois ajuda muito.',
				),
				array(
					'titulo' => 'Ultrassonografia',
					'texto' => 'Exame realizado no próprio consultório, sem dor e sem preparo, com mapeamento do material presente, das camadas envolvidas e das estruturas vasculares da região.',
				),
				array(
					'titulo' => 'Definição da conduta',
					'texto' => 'Você vê a imagem junto com o médico e entende o que existe no seu rosto. A partir daí, a conduta é decidida em conjunto: hialuronidase guiada, infiltração de medicamento, medicamento oral, retirada cirúrgica do produto ou acompanhamento.',
				),
				array(
					'titulo' => 'Aplicação e reavaliação',
					'texto' => 'Quando a retirada é indicada, a hialuronidase é aplicada de forma direcionada ao ponto identificado. A reavaliação com ultrassom verifica a resposta final.',
				),
			),
			'liftera' => array(
				array(
					'titulo' => 'Consulta e exame',
					'texto' => 'Avaliação dermatológica completa, com ultrassonografia de alta resolução da pele quando indicada, para medir espessura, qualidade do tecido e identificar o que existe na sua face — inclusive materiais de procedimentos anteriores.',
				),
				array(
					'titulo' => 'Planejamento individual',
					'texto' => 'Definição das áreas, das profundidades e do número de disparos a partir do que o exame mostrou. Se o Liftera não for o melhor caminho para o seu caso, você vai ouvir isso com clareza.',
				),
				array(
					'titulo' => 'Aplicação',
					'texto' => 'A sessão é realizada em consultório, com medidas de conforto discutidas com você antes de começar. A duração varia conforme as áreas tratadas.',
				),
				array(
					'titulo' => 'Retorno e acompanhamento',
					'texto' => 'Você volta às suas atividades no mesmo dia. O acompanhamento é feito ao longo dos meses seguintes, quando a resposta de colágeno se desenvolve.',
				),
			),
		),
		'drm_pilar' => array(
			'preenchimento' => array(
				array(
					'icone' => 'icon-pilar-explicacao.svg',
					'titulo' => 'Explicação detalhada',
					'texto' => 'Você vê a imagem do seu exame e entende, em linguagem clara, o que está acontecendo.',
				),
				array(
					'icone' => 'icon-pilar-tecnica.svg',
					'titulo' => 'Conhecimento técnico',
					'texto' => 'Atuação acadêmica dedicada a complicações de procedimentos estéticos e a biomateriais.',
				),
				array(
					'icone' => 'icon-pilar-seguranca.svg',
					'titulo' => 'Segurança',
					'texto' => 'Conduta guiada por imagem, sem aplicação às cegas.',
				),
				array(
					'icone' => 'icon-pilar-acolhimento.svg',
					'titulo' => 'Acolhimento',
					'texto' => 'Nenhum julgamento sobre o procedimento que você fez, e nenhuma pressa para decidir.',
				),
			),
			'liftera' => array(
				array(
					'icone' => 'icon-pilar-tecnica.svg',
					'titulo' => 'Conhecimento técnico',
					'texto' => 'Formação acadêmica ativa, pesquisa e ensino na universidade.',
				),
				array(
					'icone' => 'icon-pilar-explicacao.svg',
					'titulo' => 'Explicação detalhada',
					'texto' => 'Você entende o que tem, o que será feito e por quê, antes de decidir.',
				),
				array(
					'icone' => 'icon-pilar-seguranca.svg',
					'titulo' => 'Segurança',
					'texto' => 'Conduta baseada em exame de imagem e em literatura científica.',
				),
				array(
					'icone' => 'icon-pilar-acolhimento.svg',
					'titulo' => 'Acolhimento',
					'texto' => 'Consulta sem pressa, sem venda de pacote e sem promessa de resultado.',
				),
			),
		),
		'drm_faq' => array(
			'preenchimento' => array(
				array(
					'titulo' => 'A retirada de preenchimento incha?',
					'texto' => 'Sim, é esperado algum inchaço na região tratada, e ele é temporário. A hialuronidase provoca uma resposta local que costuma gerar edema nas primeiras 24 a 72 horas, às vezes com vermelhidão leve. O grau varia conforme a área, a quantidade de produto e a resposta de cada pessoa. Por isso vale planejar a aplicação levando em conta os seus compromissos das duas semanas seguintes — algo que conversamos na consulta.',
				),
				array(
					'titulo' => 'Quantas sessões são necessárias?',
					'texto' => 'Depende do tipo de material, do tempo desde a aplicação, da quantidade presente e de como o seu organismo responde. Há casos que se resolvem em uma sessão e outros que exigem aplicações sucessivas, com intervalo entre elas para avaliar a resposta. O ultrassom é usado justamente para acompanhar essa evolução e evitar aplicações desnecessárias.',
				),
				array(
					'titulo' => 'Qual o valor do tratamento?',
					'texto' => 'O valor depende de duas etapas distintas: a consulta com avaliação por ultrassonografia e, quando indicado, o tratamento em si — que varia conforme a área e a quantidade necessária. Como cada caso é diferente, os valores são informados individualmente. Nossa equipe passa todas as condições pelo WhatsApp.',
				),
				array(
					'titulo' => 'O rosto volta a ser como era antes do preenchimento?',
					'texto' => 'O objetivo é corrigir o que está causando o problema, não necessariamente devolver o rosto a um estado anterior. O resultado depende do tempo desde a aplicação, do tipo de produto e das alterações que o tecido sofreu nesse período. Na consulta, você recebe uma expectativa realista para o seu caso — o que inclui ouvir o que não é possível.',
				),
				array(
					'titulo' => 'Dói?',
					'texto' => 'O exame de ultrassom não dói. A aplicação da hialuronidase envolve o desconforto de uma injeção, com medidas de conforto discutidas antes do procedimento. As regiões mais sensíveis, como os lábios, recebem cuidado específico.',
				),
				array(
					'titulo' => 'A hialuronidase dissolve qualquer preenchimento?',
					'texto' => 'Não. A hialuronidase atua sobre o ácido hialurônico. Estimuladores de colágeno, PMMA e outros biomateriais não respondem a ela e exigem condutas diferentes. Essa é uma das razões pelas quais identificar o produto presente, antes de tratar, muda tudo.',
				),
				array(
					'titulo' => 'Faz mal tirar o preenchimento?',
					'texto' => 'Como todo procedimento médico, a aplicação de hialuronidase tem riscos, que incluem reações alérgicas e a remoção de ácido hialurônico além do desejado na região. É por isso que a indicação criteriosa e a aplicação guiada por imagem importam — e por que o procedimento deve ser realizado por médico, após avaliação.',
				),
				array(
					'titulo' => 'Fiz o preenchimento com outro profissional. Posso ser atendida?',
					'texto' => 'Sim, e essa é a situação mais comum aqui. A consulta não é sobre julgar quem aplicou: é sobre entender o que existe hoje no seu rosto e resolver o que está incomodando você.',
				),
			),
			'liftera' => array(
				array(
					'titulo' => 'O Liftera dói?',
					'texto' => 'A sensação mais comum é de calor e de pequenos pontos de desconforto durante os disparos, que passam assim que a aplicação termina. A tolerância varia bastante de pessoa para pessoa e também conforme a região tratada - áreas com menos tecido, como a testa e a linha da mandíbula, costumam ser mais sensíveis. Na consulta conversamos sobre as medidas de conforto disponíveis para o seu caso, e a aplicação é conduzida no seu ritmo.',
				),
				array(
					'titulo' => 'Quais são os cuidados depois do procedimento?',
					'texto' => 'O Liftera não exige afastamento das atividades: você sai do consultório e retoma sua rotina no mesmo dia. Pode haver vermelhidão leve, sensibilidade ao toque ou discreto inchaço nas primeiras horas ou dias. As orientações habituais envolvem fotoproteção rigorosa, hidratação da pele e evitar calor intenso e atividade física de alta intensidade nas primeiras 24 a 48 horas.',
				),
				array(
					'titulo' => 'Em quanto tempo eu vejo o resultado?',
					'texto' => 'O efeito do Liftera é progressivo, porque depende da produção de colágeno pelo seu próprio organismo. Algumas pacientes notam uma sensação inicial de firmeza logo nas primeiras semanas, mas o resultado se constrói ao longo de cerca de dois a três meses após a sessão, com evolução que pode continuar por mais tempo. É um tratamento para quem entende que o melhor resultado não é o mais imediato.',
				),
				array(
					'titulo' => 'Quantas sessões eu vou precisar?',
					'texto' => 'Não existe número padrão. Há casos em que uma sessão bem planejada é suficiente para o objetivo daquele ano; em outros, faz sentido repetir ou associar a outras tecnologias e tratamentos. O número de sessões é definido na consulta, depois da avaliação, e é sempre discutido com você antes de qualquer agendamento.',
				),
				array(
					'titulo' => 'Quanto tempo dura o resultado?',
					'texto' => 'Como o resultado vem do colágeno produzido pelo organismo, ele acompanha o processo natural de envelhecimento. Em média, fala-se em torno de um ano até que se considere uma nova sessão de manutenção, mas isso varia conforme idade, qualidade da pele, hábitos e resposta individual.',
				),
				array(
					'titulo' => 'Quem não pode fazer Liftera?',
					'texto' => 'Existem contraindicações - entre elas gestação, algumas condições de pele ativas na área a ser tratada, determinadas doenças e a presença de materiais implantados na região. Também há casos em que o grau de flacidez já ultrapassa o que um estimulador de colágeno consegue endereçar, e a indicação correta é outra. A avaliação médica existe exatamente para responder isso com segurança.',
				),
				array(
					'titulo' => 'Posso fazer Liftera se já tenho preenchimento no rosto?',
					'texto' => 'Essa é uma pergunta importante e a resposta depende de onde e o que foi aplicado. É justamente aqui que a ultrassonografia de alta resolução faz diferença: ela permite mapear o material presente na sua face antes da aplicação, para planejar as profundidades com segurança.',
				),
				array(
					'titulo' => 'Qual o valor do tratamento?',
					'texto' => 'O valor depende das áreas tratadas e do planejamento definido em consulta, e por isso é informado individualmente. Nossa equipe passa todas as condições pelo WhatsApp e a consulta de avaliação pode ser agendada pelo mesmo canal.',
				),
			),
		),
	),
	'compartilhados' => array(
		'drm_depoimento' => array(
			array(
				'texto' => '"A consulta foi muito tranquila. O doutor explicou cada etapa do exame e do tratamento com calma e clareza. Me senti segura desde o início."',
				'titulo' => 'M.C.S.',
				'data' => 'Março, 2026',
			),
			array(
				'texto' => '"Fiz a ultrassonografia de pele antes do procedimento e entendi exatamente o que seria feito. Gostei da abordagem baseada em evidências."',
				'titulo' => 'A.L.R.',
				'data' => 'Fevereiro, 2026',
			),
			array(
				'texto' => '"Ambiente acolhedor e atendimento sem pressa. Recebi todas as informações que precisava para tomar minha decisão com confiança."',
				'titulo' => 'P.F.M.',
				'data' => 'Fevereiro, 2026',
			),
		),
		'drm_formacao' => array(
			array(
				'titulo' => 'Medicina',
				'texto' => 'Universidade Federal do Paraná (UFPR)',
			),
			array(
				'titulo' => 'Residência em Dermatologia',
				'texto' => 'Escola Paulista de Medicina / UNIFESP',
			),
			array(
				'titulo' => 'Especialização em Ultrassonografia Dermatológica',
				'texto' => 'UNIFESP',
			),
			array(
				'titulo' => 'Doutorando em Medicina Translacional',
				'texto' => 'UNIFESP · linha de pesquisa: influência do ácido hialurônico na estruturação facial',
			),
			array(
				'titulo' => 'Preceptor',
				'texto' => 'Ambulatório de Ultrassom de Pele e Complicações Estéticas, UNIFESP',
			),
			array(
				'titulo' => 'Corpo clínico',
				'texto' => 'Hospital Sírio-Libanês',
			),
			array(
				'titulo' => 'Pesquisa científica',
				'texto' => 'Publicações, aulas e desenvolvimento de pesquisas com instituições como a AbbVie',
			),
		),
		'drm_foto' => array(
			array(
				'titulo' => 'Consultório na EviDenS Clinic — foto 1 de 8',
				'imagem' => 'consultorio-1.jpg',
			),
			array(
				'titulo' => 'Consultório na EviDenS Clinic — foto 2 de 8',
				'imagem' => 'consultorio-2.jpg',
			),
			array(
				'titulo' => 'Consultório na EviDenS Clinic — foto 3 de 8',
				'imagem' => 'consultorio-3.jpg',
			),
			array(
				'titulo' => 'Consultório na EviDenS Clinic — foto 4 de 8',
				'imagem' => 'consultorio-4.jpg',
			),
			array(
				'titulo' => 'Consultório na EviDenS Clinic — foto 5 de 8',
				'imagem' => 'consultorio-5.jpg',
			),
			array(
				'titulo' => 'Consultório na EviDenS Clinic — foto 6 de 8',
				'imagem' => 'consultorio-6.jpg',
			),
			array(
				'titulo' => 'Consultório na EviDenS Clinic — foto 7 de 8',
				'imagem' => 'consultorio-7.jpg',
			),
			array(
				'titulo' => 'Consultório na EviDenS Clinic — foto 8 de 8',
				'imagem' => 'consultorio-8.jpg',
			),
		),
	),
	'paginas' => array(
		'home' => array(
			'titulo' => 'Retirada de preenchimento guiada por ultrassom',
			'slug' => 'home',
			'template' => '',
			'imagem' => 'hero-rosto.jpg',
			'meta' => array(
				'drm_campanha_slug' => 'preenchimento',
				'drm_sinais_layout' => 'icone',
				'drm_hero_eyebrow' => 'Retirada de preenchimento guiada por ultrassom',
				'drm_hero_titulo' => 'Antes de dissolver, é preciso enxergar.',
				'drm_hero_lead' => 'A retirada de preenchimento feita às cegas pode remover o que não precisava sair e deixar o que estava incomodando. Aqui, o produto é localizado por ultrassonografia de alta resolução da pele antes de qualquer aplicação de hialuronidase, para tratar exatamente o que está causando o problema.',
				'drm_hero_apoio' => 'Atendimento com dermatologista especializado em ultrassonografia dermatológica pela UNIFESP, preceptor do Ambulatório de Ultrassom de Pele e Complicações Estéticas da mesma universidade.',
				'drm_hero_cta' => 'Agendar minha avaliação',
				'drm_hero_micro' => 'Atendimento na Vila Clementino, São Paulo · Resposta pelo WhatsApp',
				'drm_hero_badge_tit' => 'Segurança Avançada',
				'drm_hero_badge_txt' => 'Mapeamento de alta resolução antes do disparo da enzima.',
				'drm_hero_titulo_px' => '48',
				'drm_sinais_eyebrow' => 'SINAIS DE ALERTA',
				'drm_sinais_titulo' => 'Quando o preenchimento deixa de ser resultado e passa a ser problema',
				'drm_sinais_lead' => 'Nem todo desconforto após um preenchimento exige retirada e nem todo preenchimento que incomoda está no lugar que você imagina. Estes são os sinais que merecem avaliação médica:',
				'drm_sinais_callout' => 'Vermelhidão, dor intensa, palidez da pele ou alteração da visão logo após um preenchimento são situações de urgência e exigem atendimento médico imediato. Não espere para agendar.',
				'drm_benef_eyebrow' => 'POR QUE COM ULTRASSOM',
				'drm_benef_titulo' => 'O ultrassom mostra o que a palpação não alcança',
				'drm_benef_intro' => 'A ultrassonografia de alta resolução da pele é um exame rápido, indolor e não invasivo que permite ver, em tempo real, o que existe abaixo da superfície do seu rosto. Ela é a diferença entre tratar com base numa suposição e tratar com base numa imagem.',
				'drm_benef_rotulo' => 'O que o exame permite identificar:',
				'drm_benef_callout' => 'Com essa informação em mãos, a conduta deixa de ser genérica. Em alguns casos a indicação é a hialuronidase guiada, aplicada apenas no ponto identificado. Em outros, o melhor caminho é tratar a inflamação, drenar ou simplesmente acompanhar e evitar uma retirada que não era necessária.',
				'drm_etapas_eyebrow' => 'COMO É FEITO',
				'drm_etapas_titulo' => 'Como funciona o seu atendimento',
				'drm_dif_eyebrow' => 'DIFERENCIAL',
				'drm_dif_titulo' => 'O que você pode esperar da consulta',
				'drm_dif_rotulo' => 'Quatro pilares (o que as pacientes mais elogiam):',
				'drm_faq_eyebrow' => 'Dúvidas frequentes',
				'drm_faq_titulo' => 'Dúvidas frequentes',
				'drm_faq_botao' => 'Tire suas dúvidas',
				'drm_ctam_eyebrow' => 'Atendimento Personalizado',
				'drm_ctam_titulo' => 'Vamos olhar o seu caso com calma?',
				'drm_ctam_texto' => 'Se você está insegura com um preenchimento que fez, o primeiro passo não é dissolver: é entender. A consulta com exame de imagem responde, com clareza, o que está ali e o que pode ser feito.',
				'drm_ctam_botao' => 'Falar com a equipe no WhatsApp',
				'drm_ctam_micro' => 'Agendamento seguro e rápido · Resposta em poucos minutos',
				'drm_ctaf_titulo' => 'O primeiro passo é entender o que está ali',
				'drm_ctaf_texto' => 'Você não precisa conviver com um resultado que não te representa, e também não precisa dissolver tudo por insegurança. Uma avaliação com exame de imagem coloca a informação na mesa — e a decisão passa a ser sua, com base no que realmente existe.',
				'drm_ctaf_botao' => 'Falar com a equipe no WhatsApp',
				'drm_ctaf_micro' => 'Agendamento seguro e rápido · Resposta em poucos minutos',
			),
		),
		'liftera' => array(
			'titulo' => 'Liftera — ultrassom microfocado',
			'slug' => 'liftera',
			'template' => 'page-liftera.php',
			'imagem' => 'hero-liftera.jpg',
			'meta' => array(
				'drm_campanha_slug' => 'liftera',
				'drm_sinais_layout' => 'foto',
				'drm_hero_eyebrow' => 'Ultrassom microfocado · Dermatologia',
				'drm_hero_titulo' => 'Quando o rosto começa a perder sustentação, o caminho não é preencher mais.',
				'drm_hero_lead' => 'O Liftera é um ultrassom microfocado que leva energia térmica a camadas profundas da pele e estimula a produção de colágeno pelo seu próprio organismo. Sem cortes, sem internação e sem interromper a sua rotina.',
				'drm_hero_apoio' => 'Aqui, a indicação nunca vem antes da avaliação. Antes de qualquer aplicação, sua pele é examinada por um dermatologista com especialização em ultrassonografia de alta resolução — para que o tratamento seja escolhido a partir do que existe na sua face, e não a partir de um protocolo pronto.',
				'drm_hero_cta' => 'Agendar minha avaliação',
				'drm_hero_micro' => 'Atendimento na Vila Clementino, São Paulo · Resposta pelo WhatsApp',
				'drm_hero_badge_tit' => 'Ultrassonografia da Face',
				'drm_hero_badge_txt' => 'Mapeamento de alta resolução antes do disparo.',
				'drm_hero_titulo_px' => '37',
				'drm_sinais_eyebrow' => 'Sinais de alerta',
				'drm_sinais_titulo' => 'O que costuma trazer as pacientes até aqui',
				'drm_sinais_lead' => 'A flacidez raramente aparece de um dia para o outro. Ela se anuncia em detalhes que você percebe antes de qualquer outra pessoa, no espelho de manhã, na foto de lado, no contorno que já não é mais o mesmo.',
				'drm_sinais_callout' => 'Reconhecer esses sinais não significa que você precisa de cirurgia. Significa que vale entender, com exame e critério, em que estágio a sua flacidez está — porque é isso que define qual tratamento faz sentido.',
				'drm_benef_eyebrow' => 'Entenda o tratamento',
				'drm_benef_titulo' => 'O que é o Liftera e por que ele age em profundidade',
				'drm_benef_intro' => 'O Liftera é um equipamento de ultrassom microfocado registrado na Anvisa. Ele não preenche e não puxa a pele: entrega pontos precisos de energia térmica em camadas profundas do tecido, criando um estímulo controlado que faz o organismo responder produzindo colágeno novo ao longo das semanas seguintes.',
				'drm_benef_eyebrow_2' => 'Objetivos Clínicos',
				'drm_benef_titulo_2' => 'O que esperar do tratamento',
				'drm_benef_lead' => 'Os resultados variam de pessoa para pessoa e dependem da idade, da qualidade da pele, do grau de flacidez e da resposta individual de cada organismo. De modo geral, o tratamento é indicado com os seguintes objetivos:',
				'drm_benef_callout' => 'Nenhum tratamento estético garante resultado. A resposta é individual e depende de avaliação médica prévia. Em casos de flacidez avançada, a indicação correta pode ser cirúrgica — e essa conversa é feita na consulta, com honestidade.',
				'drm_etapas_eyebrow' => 'Como funciona',
				'drm_etapas_titulo' => 'Como é a sua sessão: passo a passo',
				'drm_etapas_lead' => 'Do planejamento clínico ao acompanhamento pós-procedimento, cada etapa é desenhada para garantir segurança e resultados naturais baseados na sua anatomia única.',
				'drm_dif_eyebrow' => 'DIFERENCIAL',
				'drm_dif_titulo' => 'Por que a avaliação vem antes do aparelho',
				'drm_dif_texto' => 'Indicar um estimulador de colágeno sem saber o que existe na face é trabalhar no escuro. A ultrassonografia de alta resolução da pele permite ver, em tempo real, a espessura das camadas, a qualidade do tecido e a presença de materiais aplicados em procedimentos anteriores — informação que muda diretamente onde e como a energia deve ser entregue.',
				'drm_dif_rotulo' => 'Quatro pilares (o que as pacientes mais elogiam):',
				'drm_faq_eyebrow' => 'Dúvidas frequentes',
				'drm_faq_titulo' => 'Dúvidas frequentes',
				'drm_faq_botao' => 'Tire suas dúvidas',
				'drm_ctam_eyebrow' => 'Atendimento Personalizado',
				'drm_ctam_titulo' => 'Vamos avaliar o seu caso?',
				'drm_ctam_texto' => 'A consulta é o momento de entender o que está acontecendo com a sua pele, ver o exame junto com você e decidir, com base em evidências, se o Liftera é o tratamento certo para o seu rosto.',
				'drm_ctam_botao' => 'Falar com a equipe no WhatsApp',
				'drm_ctam_micro' => 'Agendamento seguro e rápido · Resposta em poucos minutos',
				'drm_ctaf_titulo' => 'Sua avaliação pode começar hoje',
				'drm_ctaf_texto' => 'Se você reconheceu no seu rosto os sinais descritos nesta página, o próximo passo é simples: uma conversa. Na consulta, sua pele é examinada, suas dúvidas são respondidas sem pressa e você sai sabendo exatamente quais são as opções — inclusive a de não tratar agora.',
				'drm_ctaf_botao' => 'Falar com a equipe no WhatsApp',
				'drm_ctaf_micro' => 'Agendamento seguro e rápido · Resposta em poucos minutos',
			),
		),
		'sobre' => array(
			'titulo' => 'Sobre o médico',
			'slug' => 'sobre-o-medico',
			'imagem' => 'dr-romulo-retrato.jpg',
			'conteudo' => 'Graduado em Medicina pela Universidade Federal do Paraná e com residência médica em Dermatologia pela Escola Paulista de Medicina (UNIFESP), o Dr. Rômulo construiu sua trajetória na interseção entre a prática clínica e a pesquisa científica.

Sua especialização em ultrassonografia dermatológica pela UNIFESP mudou a forma como ele conduz a estética facial: em vez de tratar pelo que se vê na superfície, ele examina o que existe abaixo dela. Essa mesma linha orienta seu doutorado em Medicina Translacional pela UNIFESP, dedicado à influência do ácido hialurônico na estruturação facial, e sua atuação como preceptor do Ambulatório de Ultrassom de Pele e Complicações Estéticas da mesma universidade.

Atende no corpo clínico do Hospital Sírio-Libanês e na EviDenS Clinic, clínica que fundou e consolidou em São Paulo.',
		),
		'consultorio' => array(
			'titulo' => 'Consultório',
			'slug' => 'consultorio',
			'conteudo' => 'O atendimento acontece na EviDenS Clinic, na Rua Dr. Diogo de Faria, 1087 - conjuntos 901 a 904, na Vila Clementino, em São Paulo. Um espaço planejado para consultas sem pressa, com estrutura para exame de ultrassonografia de pele e realização de procedimentos no mesmo ambiente.',
		),
		'tratamento1' => array(
			'titulo' => 'O tratamento',
			'slug' => 'o-tratamento',
			'imagem' => 'ultrassom-clinica.jpg',
			'conteudo' => '',
		),
		'tratamento2' => array(
			'titulo' => 'O tratamento (Liftera)',
			'slug' => 'o-tratamento-liftera',
			'imagem' => 'liftera-clinica.jpg',
			'conteudo' => '',
		),
	),
);
