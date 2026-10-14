<?php
/**
 * Demo pages. Returns a callable that builds page content once image IDs exist.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

return function ( $img ) {
	$process = akilli_demo_block(
		'process',
		array(
			'eyebrow' => 'Nasıl çalışıyoruz',
			'title'   => 'Fikirden yayına <em>5 adım</em>.',
			'text'    => 'Net bir yol haritası, düzenli ara teslimler ve her adımda sizin onayınız. Sürpriz yok, belirsizlik yok.',
			'steps'   => akilli_demo_pairs(
				array(
					array( 'Tanışalım', 'Ücretsiz ön görüşmede hedeflerinizi, müşterilerinizi ve mevcut durumunuzu dinliyoruz.' ),
					array( 'Planlayalım', 'Kapsamı, takvimi ve bütçeyi yazılı olarak netleştiriyoruz. Neyin yapılmayacağı da belli.' ),
					array( 'Tasarlayalım', 'Kritik ekranları ve görsel dili tasarlıyor, sizinle birlikte deneyip geliştiriyoruz.' ),
					array( 'Geliştirelim', 'Tasarımı hızlı, güvenli ve kolay yönetilen bir ürüne dönüştürüp her cihazda test ediyoruz.' ),
					array( 'Yayınlayalım', 'Yayına alıyor, ekibinizi eğitiyor, ölçüm verileriyle bir sonraki adımı planlıyoruz.' ),
				)
			),
		)
	);

	$cta = function ( $title = 'Hadi, <em>başlayalım!</em>' ) {
		return akilli_demo_block(
			'cta',
			array(
				'eyebrow'      => 'Ücretsiz ön görüşme',
				'title'        => $title,
				'text'         => 'Fikrinizi 20 dakikalık bir görüşmede dinleyelim; kapsamı, takvimi ve bütçeyi yazılı olarak paylaşalım. Bir iş günü içinde dönüş yapıyoruz.',
				'btn1_text'    => 'Teklif alın',
				'btn1_url'     => '/teklif-al/',
				'btn2_text'    => 'Bize yazın',
				'btn2_url'     => '/iletisim/',
				'show_contact' => true,
			)
		);
	};

	$stats = akilli_demo_block(
		'stats',
		array(
			'eyebrow' => 'Rakamlarla',
			'title'   => 'Rakamlarla <em>Akıllı Creative</em>',
			'text'    => 'Yalnızca doğrulanmış rakamlarınızla doldurun ve görünür yapın.',
			'hidden'  => true,
			'items'   => array(),
		)
	);

	$testimonials = akilli_demo_block(
		'testimonials',
		array(
			'eyebrow' => 'Müşterilerimiz anlatıyor',
			'title'   => 'Birlikte çalıştıklarımız <em>ne diyor?</em>',
			'hidden'  => true,
			'items'   => array(),
		)
	);

	$team = akilli_demo_block(
		'team',
		array(
			'eyebrow' => 'Ekibimiz',
			'title'   => 'İşin arkasındaki <em>insanlar</em>',
			'hidden'  => true,
			'items'   => array(),
		)
	);

	$general_faq = akilli_demo_block(
		'faq',
		array(
			'eyebrow' => 'SSS',
			'title'   => 'Sık <em>sorulanlar</em>',
			'items'   => akilli_demo_pairs(
				array(
					array( 'Sadece Antalya’daki firmalarla mı çalışıyorsunuz?', 'Hayır. Ofisimiz Antalya’da; Türkiye’nin farklı şehirlerindeki firmalarla da çevrim içi toplantılar ve düzenli raporlamayla verimli şekilde çalışıyoruz. Antalya’daki müşterilerimizle yüz yüze görüşmeyi de seviyoruz.' ),
					array( 'Teklif almak ücretli mi?', 'Hayır. İlk görüşme ve yazılı teklif ücretsizdir. Kapsamlı analiz gerektiren yazılım projelerinde ücretli bir keşif aşaması önerebiliriz; bunu önceden açıkça belirtiriz.' ),
					array( 'Web sitesi, hesaplar ve kodların sahibi kim olur?', 'Alan adı, barındırma, reklam ve analiz hesapları sizin adınıza açılır. Size özel geliştirilen kod ve tasarımların kullanım hakları ödeme tamamlandığında size devredilir.' ),
					array( 'Yayından sonra destek veriyor musunuz?', 'Evet. Yayın sonrası belirli bir süre ücretsiz hata desteği veriyoruz. Sonrasında bakım, güncelleme ve geliştirme ihtiyaçlarınız için aylık destek paketleri sunuyoruz.' ),
				),
				'q',
				'a'
			),
		)
	);

	return array(
		'ana-sayfa'            => array(
			'title'   => 'Ana Sayfa',
			'seo'     => array( 'Akıllı Creative | Antalya Dijital Ajans: Web Tasarım, E-Ticaret, SEO', 'Antalya merkezli dijital ajans. Web tasarım, e-ticaret yazılımı, grafik tasarım, SEO, dijital reklam ve sosyal medya hizmetleriyle Türkiye genelinde markalara çözüm.' ),
			'content' => akilli_demo_block(
				'hero',
				array(
					'eyebrow'       => 'Antalya’dan Türkiye’ye dijital ajans',
					'title'         => 'Markanızı dijitalde <em>harekete</em> geçirelim.',
					'words'         => '',
					'text'          => 'Web siteleri, e-ticaret altyapıları, marka kimlikleri ve dijital büyüme. Hızlı, ölçülebilir ve tamamen markanıza özel.',
					'btn1_text'     => 'Ücretsiz teklif alın',
					'btn1_url'      => '/teklif-al/',
					'btn2_text'     => 'Neler yapıyoruz?',
					'btn2_url'      => '#hizmetler',
					'visual'        => 'cards',
					'chips'         => "Ücretsiz ön görüşme\n1 iş gününde dönüş\nAntalya ofis · Türkiye geneli",
					'cards'         => array(
						array( 'image' => $img['proje-otel'], 'title' => 'Butik otel kimliği', 'text' => 'Örnek proje' ),
						array( 'image' => $img['proje-moda'], 'title' => 'Moda e-ticaret', 'text' => 'Örnek proje' ),
						array( 'image' => $img['proje-klinik'], 'title' => 'Klinik web sitesi', 'text' => 'Örnek proje' ),
						array( 'image' => $img['proje-b2b'], 'title' => 'B2B sipariş paneli', 'text' => 'Örnek proje' ),
						array( 'image' => $img['proje-hukuk'], 'title' => '', 'text' => '' ),
						array( 'image' => $img['proje-dernek'], 'title' => '', 'text' => '' ),
					),
					'image'         => 0,
					'show_services' => true,
				)
			)
			. akilli_demo_block( 'marquee', array( 'items' => "Web Tasarım\nE-Ticaret\nKurumsal Kimlik\nUX / UI\nSEO\nDijital Reklam\nSosyal Medya\nÖzel Yazılım" ) )
			. akilli_demo_block(
				'booking',
				array(
					'eyebrow' => 'Hemen planlayın',
					'title'   => 'Size uygun günü <em>seçin</em>.',
					'text'    => 'Bir gün seçin, teklif formunda o gün işaretli gelsin. Ekibimiz sizi arayıp saati birlikte belirlesin.',
					'days'    => 10,
					'note'    => 'Görüşmeler yaklaşık 20 dakika sürer, ücretsizdir.',
				)
			)
			. akilli_demo_block(
				'services',
				array(
					'anchor'    => 'hizmetler',
					'eyebrow'   => 'Neler yapıyoruz?',
					'title'     => 'Dört uzmanlık, <em>tek</em> ekip.',
					'text'      => 'Tasarım, yazılım ve büyüme aynı masada. Bir alan seçin; her hizmet kendi sayfasında tüm ayrıntısıyla anlatılıyor.',
					'layout'    => 'showcase',
					'btn1_text' => 'Tüm 24 hizmeti gör',
					'btn1_url'  => '/hizmetlerimiz/',
				)
			)
			. akilli_demo_block(
				'projects',
				array(
					'eyebrow'   => 'Çalışmalar',
					'title'     => 'Neler <em>üretiyoruz?</em>',
					'text'      => 'Bu bölümdeki çalışmalar yaklaşımımızı göstermek için hazırlanmış örnek projelerdir; her birinde “Örnek proje” etiketi yer alır.',
					'layout'    => 'showcase',
					'count'     => 4,
					'btn1_text' => 'Tüm çalışmalar',
					'btn1_url'  => '/calismalarimiz/',
				)
			)
			. $process
			. $stats
			. $testimonials
			. $team
			. akilli_demo_block(
				'features',
				array(
					'eyebrow' => 'Neden Akıllı Creative?',
					'title'   => 'Bizimle çalışmanın <em>altı</em> güzel yanı.',
					'style'   => 'cards',
					'items'   => array(
						array(
							'icon'  => 'layers',
							'title' => 'Tek ekip, uçtan uca',
							'text'  => 'Strateji, tasarım, yazılım ve pazarlama aynı ekipte. “O iş bizde değil” cevabı yok.',
						),
						array(
							'icon'  => 'code',
							'title' => 'Kodunu biz yazıyoruz',
							'text'  => 'Hazır şablon yığınları yerine ihtiyacınıza göre yazılmış hafif ve hızlı kod.',
						),
						array(
							'icon'  => 'target',
							'title' => 'Ölçülebilir hedefler',
							'text'  => 'Başarıyı baştan tanımlıyor, ölçüm altyapısını yayın gününe hazır ediyoruz.',
						),
						array(
							'icon'  => 'gear',
							'title' => 'Kolay yönetim',
							'text'  => 'İçeriklerinizi kod bilmeden güncelleyebileceğiniz sade yönetim panelleri.',
						),
						array(
							'icon'  => 'shield',
							'title' => 'Dürüst vaatler',
							'text'  => 'Sıralama, satış veya takipçi garantisi vermiyoruz. Neyi neden yaptığımızı açıkça anlatıyoruz.',
						),
						array(
							'icon'  => 'map-pin',
							'title' => 'Yakınınızdayız',
							'text'  => 'Antalya’daki ofisimizde yüz yüze, Türkiye genelinde çevrim içi toplantılarla.',
						),
					),
				)
			)
			. akilli_demo_block(
				'references',
				array(
					'eyebrow' => 'Referanslar',
					'title'   => 'Birlikte çalıştığımız markalar',
					'layout'  => 'marquee',
				)
			)
			. akilli_demo_block(
				'posts',
				array(
					'eyebrow'   => 'Blog',
					'title'     => 'Dijitalde doğru kararlar için <em>ipuçları</em>.',
					'count'     => 3,
					'btn1_text' => 'Tüm yazılar',
					'btn1_url'  => '/blog/',
				)
			)
			. $general_faq
			. $cta(),
		),
		'hakkimizda'           => array(
			'title'   => 'Hakkımızda',
			'seo'     => array( 'Hakkımızda | Antalya Merkezli Dijital Ajans | Akıllı Creative', 'Akıllı Creative; tasarım, yazılım ve dijital büyümeyi aynı masada düşünen Antalya merkezli bir dijital ajans. Çalışma ilkelerimizi ve sürecimizi tanıyın.' ),
			'excerpt' => 'Tasarımı, yazılımı ve büyümeyi aynı masada düşünen, Antalya merkezli bir dijital ajansız.',
			'content' => akilli_demo_block(
				'page-hero',
				array(
					'eyebrow'   => 'Hakkımızda',
					'title'     => 'Fikirleri <em>canlandıran</em> ekip.',
					'text'      => 'Akıllı Creative, Antalya merkezli bir dijital ajans. Türkiye genelindeki firmalar, klinikler, hukuk büroları, dernekler ve e-ticaret markalarıyla web, yazılım, tasarım ve dijital pazarlama projeleri yürütüyoruz.',
					'btn1_text' => 'Çalışmalarımızı incele',
					'btn1_url'  => '/calismalarimiz/',
				)
			)
			. akilli_demo_block(
				'split',
				array(
					'eyebrow'   => 'Biz kimiz?',
					'title'     => 'Tek masa, <em>tek</em> ekip.',
					'text'      => "Dijital projelerde en sık yaşanan sorun, işin farklı parçalarının birbirinden habersiz ilerlemesidir: tasarımcı bir şey düşünür, yazılımcı başka bir şey uygular, pazarlama ekibi ise bambaşka bir mesaj verir.\n\nAkıllı Creative’i bu kopukluğu ortadan kaldırmak için kurduk. Strateji, tasarım, yazılım ve dijital pazarlama aynı ekipte, aynı hedefe bakarak çalışır. Böylece ortaya çıkan iş hem güzel görünür, hem hızlı çalışır, hem de gerçekten işinize yarar.",
					'items'     => "Web tasarım ve yazılım\nE-ticaret ve ödeme sistemleri\nMarka ve grafik tasarım\nSEO, reklam ve sosyal medya",
					'image'     => $img['studio-katmanlar'],
					'btn1_text' => 'Hizmetlerimiz',
					'btn1_url'  => '/hizmetlerimiz/',
				)
			)
			. akilli_demo_block(
				'statement',
				array(
					'eyebrow' => 'İnandığımız şey',
					'text'    => 'İyi bir dijital ürün, <em>doğru soruyla</em> başlar. Kod yazmadan önce soru sorar, tasarlamadan önce dinleriz.',
				)
			)
			. akilli_demo_block(
				'features',
				array(
					'eyebrow' => 'Çalışma ilkelerimiz',
					'title'   => 'Birlikte çalışırken <em>güvenebileceğiniz</em> şeyler.',
					'style'   => 'cards',
					'items'   => array(
						array(
							'icon'  => 'shield',
							'title' => 'Dürüst vaat',
							'text'  => 'Google sıralaması, satış ya da takipçi garantisi vermeyiz. Gerçekçi hedefler koyar, ilerlemeyi şeffaf biçimde raporlarız.',
						),
						array(
							'icon'  => 'id',
							'title' => 'Sahiplik sizde',
							'text'  => 'Alan adı, hesaplar, kod ve tasarım dosyaları sizindir. Çalışmamız bittiğinde eksiksiz devir yaparız.',
						),
						array(
							'icon'  => 'growth',
							'title' => 'Ölçmeden karar vermeyiz',
							'text'  => 'Önemli kararları kullanıcı davranışı, analiz verileri ve testlerle destekleriz.',
						),
						array(
							'icon'  => 'users',
							'title' => 'Herkes için erişilebilir',
							'text'  => 'Klavyeyle gezinme, okunabilir kontrast ve hareket hassasiyeti gibi ihtiyaçları baştan tasarıma dahil ederiz.',
						),
						array(
							'icon'  => 'chat',
							'title' => 'Sade iletişim',
							'text'  => 'Teknik konuları anlaşılır bir dille anlatır, her aşamanın sonunda net bir özet paylaşırız.',
						),
						array(
							'icon'  => 'compass',
							'title' => 'Uzun soluklu destek',
							'text'  => 'Yayından sonra da yanınızdayız: bakım, geliştirme ve büyüme çalışmalarıyla.',
						),
					),
				)
			)
			. $team
			. $process
			. $stats
			. $testimonials
			. $cta( 'Sizi <em>tanımak</em> isteriz.' ),
		),
		'hizmetlerimiz'        => array(
			'title'   => 'Hizmetlerimiz',
			'seo'     => array( 'Hizmetlerimiz | Web, E-Ticaret, Tasarım, SEO | Akıllı Creative', 'Web tasarım, e-ticaret yazılımı, grafik tasarım ve dijital büyüme hizmetlerimizin tamamı. İhtiyacınıza uygun hizmeti seçin, teklif alın.' ),
			'excerpt' => 'Web tasarım, e-ticaret yazılımı, grafik tasarım ve dijital büyüme alanlarındaki tüm hizmetlerimiz.',
			'content' => akilli_demo_block(
				'page-hero',
				array(
					'eyebrow'   => 'Hizmetlerimiz',
					'title'     => 'Dört disiplin, <em>yirmi dört</em> hizmet.',
					'text'      => 'Dört ana alanda 24 hizmet sunuyoruz. İster tek bir hizmetle başlayın, ister tasarımdan yazılıma ve büyümeye kadar uçtan uca bir proje planlayalım.',
					'btn1_text' => 'Teklif al',
					'btn1_url'  => '/teklif-al/',
				)
			)
			. akilli_demo_block(
				'services',
				array(
					'eyebrow' => 'Tüm hizmetler',
					'title'   => 'Tüm <em>hizmetler</em>',
					'layout'  => 'grid',
				)
			)
			. akilli_demo_block(
				'features',
				array(
					'eyebrow' => 'Nereden başlamalı?',
					'title'   => 'Nereden <em>başlamalı</em>?',
					'style'   => 'numbered',
					'items'   => array(
						array(
							'title' => 'Yeni kuruluyorsanız',
							'text'  => 'Önce logo ve temel kurumsal kimliği, ardından kurumsal web sitesini planlayın. İkisini birlikte ele almak hem zaman hem bütçe kazandırır.',
							'url'   => '/hizmetlerimiz/grafik-tasarim/kurumsal-kimlik-tasarimi/',
						),
						array(
							'title' => 'Online satışa geçecekseniz',
							'text'  => 'Altyapı seçimini ürün yapınıza ve büyüme planınıza göre yapın. Emin değilseniz e-ticaret danışmanlığıyla başlayın.',
							'url'   => '/hizmetlerimiz/dijital-buyume/e-ticaret-danismanligi/',
						),
						array(
							'title' => 'Siteniz var ama talep gelmiyorsa',
							'text'  => 'Önce ölçüm ve teknik SEO denetimiyle sorunu tespit edin, ardından içerik ve reklam çalışmalarını planlayın.',
							'url'   => '/hizmetlerimiz/dijital-buyume/seo/',
						),
						array(
							'title' => 'Süreçleriniz tablolarla yürüyorsa',
							'text'  => 'En çok zaman kaybettiren süreci seçip küçük bir özel yazılım ilk sürümüyle başlayın.',
							'url'   => '/hizmetlerimiz/dijital-buyume/ozel-yazilim-cozumleri/',
						),
					),
				)
			)
			. $process
			. $general_faq
			. $cta(),
		),
		'referanslarimiz'      => array(
			'title'   => 'Referanslarımız',
			'seo'     => array( 'Referanslarımız | Akıllı Creative', 'Akıllı Creative’in birlikte çalıştığı markalar, odaklandığı sektörler ve örnek çalışmaları.' ),
			'excerpt' => 'Birlikte çalıştığımız markalar ve odaklandığımız sektörler.',
			'content' => akilli_demo_block(
				'page-hero',
				array(
					'eyebrow' => 'Referanslarımız',
					'title'   => 'Güven, <em>işle</em> kazanılır.',
					'text'    => 'Farklı sektörlerden markalarla web, e-ticaret, tasarım ve dijital pazarlama projeleri yürütüyoruz. Referans logolarını yalnızca müşterilerimizin izniyle paylaşıyoruz.',
				)
			)
			. akilli_demo_block(
				'references',
				array(
					'eyebrow' => 'Markalar',
					'title'   => 'Birlikte çalıştığımız markalar',
					'layout'  => 'grid',
				)
			)
			. akilli_demo_block(
				'features',
				array(
					'eyebrow' => 'Sektörler',
					'title'   => 'Odaklandığımız <em>sektörler</em>',
					'text'    => 'Her sektörün kendi kuralları, müşteri beklentileri ve iletişim dili var. Hizmetlerimizi bu farklılıkları gözeterek kurguluyoruz.',
					'style'   => 'cards',
					'items'   => array(
						array(
							'icon'  => 'tooth',
							'title' => 'Sağlık ve klinikler',
							'text'  => 'Tedavi bilgilendirmesi, randevu akışı ve sağlık turizmi için çok dilli yapılar.',
							'url'   => '/hizmetlerimiz/web-tasarim/dis-klinigi-web-tasarimi/',
						),
						array(
							'icon'  => 'scale',
							'title' => 'Hukuk büroları',
							'text'  => 'Reklam yasağını gözeten, bilgilendirici ve ölçülü web siteleri.',
							'url'   => '/hizmetlerimiz/web-tasarim/avukat-web-tasarimi/',
						),
						array(
							'icon'  => 'cart',
							'title' => 'Perakende ve e-ticaret',
							'text'  => 'Online mağaza, ödeme sistemleri ve kampanya yönetimi.',
							'url'   => '/hizmetlerimiz/e-ticaret-yazilimi/',
						),
						array(
							'icon'  => 'plane',
							'title' => 'Turizm ve konaklama',
							'text'  => 'Marka kimliği, çok dilli web siteleri ve sezonluk dijital kampanyalar.',
							'url'   => '/hizmetlerimiz/grafik-tasarim/kurumsal-kimlik-tasarimi/',
						),
						array(
							'icon'  => 'heart',
							'title' => 'Dernek ve vakıflar',
							'text'  => 'Faaliyet, bağış ve gönüllü süreçlerini kolaylaştıran siteler.',
							'url'   => '/hizmetlerimiz/web-tasarim/dernek-web-sitesi-tasarimi/',
						),
						array(
							'icon'  => 'gear',
							'title' => 'Üretim ve B2B',
							'text'  => 'Bayi portalları, sipariş sistemleri ve ERP entegrasyonları.',
							'url'   => '/hizmetlerimiz/e-ticaret-yazilimi/sifirdan-e-ticaret-yazilimi/',
						),
					),
				)
			)
			. akilli_demo_block(
				'projects',
				array(
					'eyebrow'   => 'Çalışmalar',
					'title'     => 'Örnek <em>çalışmalar</em>',
					'layout'    => 'grid',
					'count'     => 6,
					'btn1_text' => 'Tüm çalışmalar',
					'btn1_url'  => '/calismalarimiz/',
				)
			)
			. $cta(),
		),
		'calismalarimiz'       => array(
			'title'   => 'Çalışmalarımız',
			'seo'     => array( 'Çalışmalarımız | Web, E-Ticaret ve Tasarım Projeleri | Akıllı Creative', 'Web sitesi, e-ticaret, marka kimliği ve yazılım projelerimizi kategori ve hizmete göre filtreleyerek inceleyin.' ),
			'excerpt' => 'Web, e-ticaret, tasarım ve yazılım çalışmalarımızı kategori ve hizmete göre inceleyin.',
			'content' => akilli_demo_block(
				'page-hero',
				array(
					'eyebrow' => 'Çalışmalarımız',
					'title'   => 'Her proje, bir <em>sorunun</em> zarif cevabı.',
					'text'    => 'Çalışmaları kategoriye veya hizmete göre filtreleyin; her projede ihtiyacı, çözümü ve kullanılan altyapıyı bulabilirsiniz. “Örnek proje” notu taşıyan çalışmalar, yaklaşımımızı anlatmak için hazırlanmış örneklerdir.',
				)
			)
			. akilli_demo_block(
				'projects',
				array(
					'layout'       => 'grid',
					'show_filters' => true,
					'count'        => 100,
					'title'        => '',
				)
			)
			. $cta( 'Sıradaki <em>sizinki</em> olsun.' ),
		),
		'blog'                 => array(
			'title'   => 'Blog',
			'seo'     => array( 'Blog | Web, E-Ticaret, SEO ve Tasarım Rehberleri | Akıllı Creative', 'Web tasarım, e-ticaret, sanal POS, SEO ve marka tasarımı üzerine işletmeler için hazırlanmış pratik rehberler.' ),
			'excerpt' => 'Web, e-ticaret, SEO ve tasarım üzerine işletmeler için pratik rehberler.',
			'content' => '',
		),
		'teklif-al'            => array(
			'title'   => 'Teklif Al',
			'seo'     => array( 'Teklif Al | Akıllı Creative', 'Web tasarım, e-ticaret, grafik tasarım, SEO veya dijital reklam projeniz için ücretsiz teklif isteyin. En geç bir iş günü içinde dönüş yapıyoruz.' ),
			'excerpt' => 'Projenizi anlatın, size özel kapsam ve teklif hazırlayalım.',
			'content' => akilli_demo_block(
				'page-hero',
				array(
					'eyebrow' => 'Teklif al',
					'title'   => 'Projenizi <em>anlatın</em>.',
					'text'    => 'Formu doldurmanız birkaç dakika sürer. İhtiyacınızı inceleyip size uygun kapsamı, takvimi ve ücreti yazılı olarak paylaşıyoruz.',
				)
			)
			. akilli_demo_block(
				'quote-form',
				array(
					'anchor'     => 'teklif',
					'title'      => 'Teklif formu',
					'show_aside' => true,
				)
			)
			. akilli_demo_block(
				'faq',
				array(
					'eyebrow' => 'SSS',
					'title'   => 'Teklif süreci hakkında',
					'items'   => akilli_demo_pairs(
						array(
							array( 'Ne kadar sürede dönüş yapıyorsunuz?', 'Mesai saatleri içinde gelen taleplere genellikle aynı gün, en geç bir iş günü içinde dönüş yapıyoruz.' ),
							array( 'Bütçemi bilmiyorum, yine de teklif alabilir miyim?', 'Elbette. Bütçe alanı isteğe bağlıdır. İhtiyacınızı anlattığınızda farklı kapsam seçeneklerini ve yaklaşık maliyetlerini birlikte değerlendirebiliriz.' ),
							array( 'Paylaştığım bilgiler nasıl korunuyor?', 'Form bilgileri yalnızca talebinize yanıt vermek amacıyla, yetkili ekip üyelerinin erişebildiği yönetim panelinde saklanır. Ayrıntılar için KVKK aydınlatma metnimizi inceleyebilirsiniz.' ),
						),
						'q',
						'a'
					),
				)
			),
		),
		'iletisim'             => array(
			'title'   => 'İletişim',
			'seo'     => array( 'İletişim | Akıllı Creative Antalya', 'Akıllı Creative ile iletişime geçin: +90 530 611 82 80, info@akillicreative.com. Kızılsaray Mah. Ofisbudur Plaza, Muratpaşa / Antalya.' ),
			'excerpt' => 'Telefon, WhatsApp, e-posta veya form üzerinden bize ulaşın.',
			'content' => akilli_demo_block(
				'page-hero',
				array(
					'eyebrow' => 'İletişim',
					'title'   => 'Bir kahve, bir <em>görüşme</em>.',
					'text'    => 'Muratpaşa’daki ofisimizde sizi ağırlamaktan memnuniyet duyarız. Telefon, WhatsApp veya e-postayla da ulaşabilirsiniz.',
				)
			)
			. akilli_demo_block(
				'contact',
				array(
					'eyebrow'   => 'Bize ulaşın',
					'title'     => 'İletişim bilgileri',
					'show_form' => true,
				)
			),
		),
		'gizlilik-politikasi'  => array(
			'title'   => 'Gizlilik Politikası',
			'seo'     => array( 'Gizlilik Politikası | Akıllı Creative', 'Akıllı Creative web sitesinde kişisel verilerin nasıl toplandığı, kullanıldığı ve korunduğu hakkında bilgilendirme.' ),
			'content' => akilli_demo_p( '<em>Son güncelleme: ' . wp_date( 'd.m.Y' ) . '. Bu metin genel bir şablondur; yayınlamadan önce hukuk danışmanınızla gözden geçirip şirket unvanı ve iletişim bilgilerinizi kesinleştirin.</em>' )
			. akilli_demo_p( 'Bu gizlilik politikası, Akıllı Creative (“biz”) tarafından işletilen bu web sitesini ziyaret ettiğinizde kişisel verilerinizin nasıl işlendiğini açıklar. Kişisel verileriniz 6698 sayılı Kişisel Verilerin Korunması Kanunu (KVKK) ve ilgili mevzuata uygun olarak işlenir.' )
			. akilli_demo_h( 'Hangi verileri topluyoruz?' )
			. akilli_demo_list(
				array(
					'<strong>Form verileri:</strong> Teklif ve iletişim formlarında paylaştığınız ad soyad, firma, e-posta, telefon, ilgilendiğiniz hizmet, bütçe aralığı ve mesajınız.',
					'<strong>Teknik veriler:</strong> Sunucu kayıtları (IP adresi, tarayıcı bilgisi, ziyaret zamanı) güvenlik ve hata tespiti amacıyla barındırma altyapısı tarafından tutulabilir.',
					'<strong>Tercih bilgileri:</strong> Hareket azaltma tercihi gibi site ayarları yalnızca tarayıcınızda saklanır.',
				)
			)
			. akilli_demo_h( 'Verileri hangi amaçlarla kullanıyoruz?' )
			. akilli_demo_list(
				array(
					'Teklif ve iletişim taleplerinize yanıt vermek',
					'Hizmet sözleşmesi öncesi görüşmeleri yürütmek',
					'Web sitesinin güvenliğini sağlamak ve kötüye kullanımı (spam) önlemek',
					'Yasal yükümlülüklerimizi yerine getirmek',
				)
			)
			. akilli_demo_h( 'Spam koruması' )
			. akilli_demo_p( 'Formlarımızda kötüye kullanımı önlemek için gönderim hızı sınırlaması uygulanır. Bu amaçla IP adresiniz geri döndürülemez şekilde özetlenerek (hash) kısa süreliğine geçici bellekte tutulur ve talep kaydınızla birlikte saklanmaz.' )
			. akilli_demo_h( 'Verileri kimlerle paylaşıyoruz?' )
			. akilli_demo_p( 'Kişisel verileriniz satılmaz ve pazarlama amacıyla üçüncü kişilerle paylaşılmaz. Verileriniz yalnızca hizmet aldığımız barındırma ve e-posta altyapısı sağlayıcıları ile yasal zorunluluk hâlinde yetkili kurumlarla paylaşılabilir.' )
			. akilli_demo_h( 'Saklama süresi' )
			. akilli_demo_p( 'Form talepleri, talebin amacı için gerekli olan süre boyunca ve ilgili mevzuattaki saklama süreleri kadar tutulur; süre sonunda silinir veya anonim hale getirilir.' )
			. akilli_demo_h( 'Haklarınız' )
			. akilli_demo_p( 'KVKK’nın 11. maddesi kapsamında verilerinizin işlenip işlenmediğini öğrenme, düzeltilmesini veya silinmesini isteme gibi haklara sahipsiniz. Taleplerinizi <a href="mailto:info@akillicreative.com">info@akillicreative.com</a> adresine iletebilirsiniz. Ayrıntılar için <a href="{page:kvkk-aydinlatma-metni}">KVKK Aydınlatma Metni</a> ve <a href="{page:cerez-politikasi}">Çerez Politikası</a> sayfalarımızı inceleyin.' ),
		),
		'cerez-politikasi'     => array(
			'title'   => 'Çerez Politikası',
			'seo'     => array( 'Çerez Politikası | Akıllı Creative', 'Akıllı Creative web sitesinde kullanılan çerezler ve tarayıcı depolama alanları hakkında bilgilendirme.' ),
			'content' => akilli_demo_p( '<em>Son güncelleme: ' . wp_date( 'd.m.Y' ) . '. Siteye analiz, reklam veya sohbet aracı eklediğinizde bu sayfayı güncelleyin; bu tür araçlar genellikle açık rıza gerektirir.</em>' )
			. akilli_demo_p( 'Çerezler, ziyaret ettiğiniz web sitelerinin tarayıcınıza kaydettiği küçük metin dosyalarıdır. Bu sayfa, sitemizde hangi çerezlerin ve tarayıcı depolama alanlarının kullanıldığını açıklar.' )
			. akilli_demo_h( 'Varsayılan olarak kullandıklarımız' )
			. akilli_demo_list(
				array(
					'<strong>Zorunlu WordPress çerezleri:</strong> Yalnızca yönetim paneline giriş yapan kullanıcılar için oturum çerezleri oluşturulur. Ziyaretçiler için oturum çerezi kullanılmaz.',
					'<strong>Tercih kaydı (yerel depolama):</strong> “Hareketi azalt” tercihiniz ve çerez bilgilendirmesini kapattığınız bilgisi tarayıcınızın yerel depolama alanında tutulur; sunucumuza gönderilmez.',
				)
			)
			. akilli_demo_h( 'Kullanmadıklarımız' )
			. akilli_demo_p( 'Sitemiz varsayılan kurulumda reklam, izleme veya üçüncü taraf analiz çerezi kullanmaz. Yazı tipleri sitemizin kendi sunucusundan yüklenir; harita yalnızca bağlantıya tıkladığınızda Google Haritalar’da açılır.' )
			. akilli_demo_h( 'Çerezleri nasıl yönetebilirsiniz?' )
			. akilli_demo_p( 'Tarayıcınızın ayarlarından çerezleri ve site verilerini silebilir veya engelleyebilirsiniz. Zorunlu çerezleri engellemeniz durumunda yönetim paneline giriş gibi bazı işlevler çalışmayabilir.' )
			. akilli_demo_p( 'Sorularınız için <a href="{page:iletisim}">iletişim sayfamızdan</a> bize ulaşabilirsiniz.' ),
		),
		'kvkk-aydinlatma-metni' => array(
			'title'   => 'KVKK Aydınlatma Metni',
			'seo'     => array( 'KVKK Aydınlatma Metni | Akıllı Creative', 'Akıllı Creative web sitesi formları aracılığıyla işlenen kişisel veriler hakkında 6698 sayılı KVKK kapsamında aydınlatma metni.' ),
			'content' => akilli_demo_p( '<em>Bu metin genel bir şablondur. Veri sorumlusunun tam unvanı, adresi ve VERBİS bilgileri gibi ayrıntıları hukuk danışmanınızla birlikte kesinleştirin.</em>' )
			. akilli_demo_h( 'Veri sorumlusu' )
			. akilli_demo_p( 'Akıllı Creative — Kızılsaray Mah. Ofisbudur Plaza No:26/101 Kat 1, Muratpaşa / Antalya · <a href="mailto:info@akillicreative.com">info@akillicreative.com</a>' )
			. akilli_demo_h( 'İşlenen kişisel veriler' )
			. akilli_demo_p( 'Teklif ve iletişim formları aracılığıyla; kimlik (ad soyad), iletişim (e-posta, telefon), müşteri işlem (firma, talep edilen hizmet, bütçe aralığı, mesaj içeriği) ve işlem güvenliği (form gönderim zamanı, onay zamanı) verileriniz işlenir.' )
			. akilli_demo_h( 'İşleme amaçları ve hukuki sebepler' )
			. akilli_demo_p( 'Verileriniz; talebinize yanıt verilmesi, teklif hazırlanması ve sözleşme öncesi görüşmelerin yürütülmesi amaçlarıyla KVKK’nın 5/2-c maddesi (bir sözleşmenin kurulması veya ifasıyla doğrudan ilgili olması) ve 5/2-f maddesi (meşru menfaat) kapsamında işlenir.' )
			. akilli_demo_h( 'Aktarım' )
			. akilli_demo_p( 'Verileriniz, hizmet aldığımız barındırma ve e-posta altyapısı sağlayıcılarına yalnızca hizmetin gerektirdiği ölçüde ve yasal zorunluluk hâlinde yetkili kamu kurumlarına aktarılabilir. Kullanılan sağlayıcıların sunucularının yurt dışında bulunması hâlinde KVKK’nın 9. maddesindeki şartlara uyulur.' )
			. akilli_demo_h( 'Toplama yöntemi' )
			. akilli_demo_p( 'Verileriniz web sitemizdeki formlar aracılığıyla elektronik ortamda toplanır.' )
			. akilli_demo_h( 'Haklarınız' )
			. akilli_demo_p( 'KVKK’nın 11. maddesi uyarınca; verilerinizin işlenip işlenmediğini öğrenme, işlenmişse bilgi talep etme, amacına uygun kullanılıp kullanılmadığını öğrenme, aktarıldığı üçüncü kişileri bilme, eksik veya yanlış işlenmişse düzeltilmesini, şartları oluştuğunda silinmesini veya yok edilmesini isteme ve zarara uğramanız hâlinde giderilmesini talep etme haklarına sahipsiniz. Başvurularınızı yukarıdaki iletişim adreslerine iletebilirsiniz.' ),
		),
	);
};
