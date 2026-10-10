<?php
/**
 * Demo content: E-Ticaret Yazılımı category.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'    => 'E-Ticaret Yazılımı',
	'slug'     => 'e-ticaret-yazilimi',
	'icon'     => 'cart',
	'excerpt'  => 'Hazır paketten sıfırdan yazılıma, sanal POS entegrasyonundan yeni özellik geliştirmeye kadar online satışınızın teknik altyapısını kuruyoruz.',
	'seo'      => array( 'E-Ticaret Yazılımı ve Entegrasyon | Akıllı Creative', 'Hazır e-ticaret siteleri, özel e-ticaret yazılımı, WooCommerce, sanal POS ve API entegrasyonları. İşletmenize uygun altyapıyı birlikte seçelim.' ),
	'intro'    => array(
		'E-ticarette doğru altyapı; ürün sayınıza, satış kanallarınıza, ödeme ve kargo süreçlerinize, ekibinizin büyüklüğüne ve büyüme planınıza göre değişir. Herkese aynı paketi önermek yerine ihtiyacınızı inceleyip size uygun yolu birlikte seçiyoruz.',
		'Hazır bir altyapıyla hızlı başlamak, WordPress ile esnek bir mağaza kurmak ya da iş süreçlerinize özel bir yazılım geliştirmek; hangisini seçersek seçelim ödeme güvenliği, mobil alışveriş deneyimi ve yönetim kolaylığı önceliğimizdir.',
	),
	'common'   => array(
		'Mobilde hızlı ve sade ödeme (checkout) akışı',
		'3D Secure destekli güvenli ödeme entegrasyonu',
		'Mesafeli satış sözleşmesi, iade ve KVKK sayfa şablonları',
		'Ürün, sipariş ve stok yönetimi için anlaşılır panel',
		'Ürün yapılandırılmış verisi ve kategori SEO altyapısı',
		'Kargo ve fatura süreçleri için entegrasyon planı',
	),
	'faq'      => array(
		array( 'Hangi e-ticaret altyapısını seçmeliyim?', 'Ürün sayınız, beklenen sipariş hacmi, entegrasyon ihtiyaçlarınız ve bütçeniz belirleyicidir. İlk görüşmede bu bilgileri alıp hazır paket, WordPress (WooCommerce) ve özel yazılım seçeneklerinin artı ve eksilerini somut olarak karşılaştırıyoruz.' ),
		array( 'Satış garantisi veriyor musunuz?', 'Hayır. Satışlar ürününüze, fiyatınıza, rekabete ve pazarlama çalışmalarına bağlıdır. Biz satış yapmayı kolaylaştıran, güven veren ve ölçülebilir bir altyapı kuruyoruz; isterseniz büyüme tarafında da danışmanlık veriyoruz.' ),
		array( 'Mevcut mağazamı taşıyabilir misiniz?', 'Çoğu durumda ürün, kategori, müşteri ve sipariş verilerini yeni altyapıya aktarabiliyoruz. Aktarım kapsamını, mevcut sisteminizin dışa aktarma imkânlarını inceledikten sonra netleştiriyoruz.' ),
	),
	'children' => array(
		array(
			'title'   => 'Hazır E-Ticaret Siteleri',
			'slug'    => 'hazir-e-ticaret-siteleri',
			'icon'    => 'rocket',
			'label'   => 'Hazır E-Ticaret',
			'excerpt' => 'Kanıtlanmış bir altyapı üzerinde, markanıza göre düzenlenmiş ve kısa sürede satışa açılabilen e-ticaret siteleri.',
			'seo'     => array( 'Hazır E-Ticaret Sitesi Kurulumu | Hızlı Başlangıç | Akıllı Creative', 'Online satışa hızlı başlamak isteyenler için markanıza göre düzenlenmiş hazır e-ticaret siteleri. Ödeme, kargo ve ürün yönetimi kurulu teslim.' ),
			'intro'   => array(
				'Online satışa ilk kez başlayacaksanız veya ürün yelpazeniz standart bir mağaza yapısına uyuyorsa, her şeyi sıfırdan yazmak gerekmez. Hazır e-ticaret sitelerinde kanıtlanmış bir altyapıyı markanıza göre düzenliyor, ödeme, kargo ve temel ayarlarını yapıp satışa hazır teslim ediyoruz.',
				'“Hazır” olması özensiz olduğu anlamına gelmez: tasarımı kurumsal kimliğinize uyarlıyor, ürün sayfalarını mobilde rahat alışveriş yapılacak şekilde düzenliyor ve ödeme adımlarını sadeleştiriyoruz. İşleriniz büyüdüğünde <a href="{home}/hizmetlerimiz/e-ticaret-yazilimi/yeni-ozellik-ekleme-php/">yeni özellik geliştirme</a> veya daha esnek bir altyapıya geçiş için yol haritasını baştan konuşuyoruz.',
			),
			'scope'   => array(
				array( 'Altyapı seçimi ve kurulum', 'Ürün sayınıza ve bütçenize uygun hazır altyapıyı seçip kurulumunu yapıyoruz.' ),
				array( 'Markaya uyarlanmış tasarım', 'Renk, tipografi, logo ve görsel dili mağazanın tüm sayfalarına uyguluyoruz.' ),
				array( 'Ödeme ve kargo ayarları', 'Sanal POS veya ödeme kuruluşu entegrasyonunu, kargo ücret kurallarını ve teslimat seçeneklerini yapılandırıyoruz.' ),
				array( 'Ürün yükleme desteği', 'İlk ürünlerinizi kategori yapısıyla birlikte yüklüyor, toplu yükleme şablonunu hazırlıyoruz.' ),
				array( 'Yasal sayfalar', 'Mesafeli satış sözleşmesi, ön bilgilendirme, iade ve KVKK sayfaları için şablon yapı kuruyoruz.' ),
			),
			'for'     => array(
				array( 'İlk kez online satış yapacaklar', 'Mağazasını internete taşımak isteyen butik işletmeler.' ),
				array( 'Sınırlı ürün yelpazesi', 'Yüzlerce değil, düzinelerce ürünle başlayan markalar.' ),
				array( 'Hızlı başlamak isteyenler', 'Sezon, kampanya veya lansman nedeniyle kısa sürede açılması gereken mağazalar.' ),
			),
			'needs'   => array(
				array( 'Kısa sürede satışa başlamak', 'Kanıtlanmış altyapıyla geliştirme süresini kısaltıyoruz.' ),
				array( 'Düşük başlangıç maliyeti', 'Özel geliştirme gerektirmeyen ihtiyaçları hazır özelliklerle karşılıyoruz.' ),
				array( 'Teknik bilgi olmadan yönetim', 'Sipariş, ürün ve stok yönetimini ekibinize öğretiyoruz.' ),
			),
			'deliver' => array( 'Kurulu ve markaya uyarlanmış e-ticaret sitesi', 'Ödeme ve kargo yapılandırması', 'Kategori yapısı ve ilk ürün yüklemesi', 'Toplu ürün yükleme şablonu', 'Yasal sayfa şablonları', 'Sipariş ve ürün yönetimi eğitimi' ),
			'process' => array(
				array( 'İhtiyaç analizi', 'Ürünlerinizi, satış hedefinizi ve operasyonunuzu konuşuyoruz.' ),
				array( 'Altyapı ve tasarım', 'Altyapıyı seçip tasarımı markanıza uyarlıyoruz.' ),
				array( 'Ayarlar ve entegrasyonlar', 'Ödeme, kargo, vergi ve bildirim ayarlarını yapıyoruz.' ),
				array( 'Ürünler ve test siparişleri', 'Ürünleri yükleyip gerçek kartla test siparişleri veriyoruz.' ),
				array( 'Yayın ve eğitim', 'Mağazayı açıyor, ekibinizi eğitiyoruz.' ),
			),
			'faq'     => array(
				array( 'Hazır e-ticaret sitesinde neleri değiştiremem?', 'Altyapının sunduğu temel işleyiş (ör. sepet ve ödeme adımlarının mantığı) sınırlı ölçüde değiştirilebilir. Tasarım, içerik, kategori yapısı ve ayarlar ise markanıza göre düzenlenir. Özel iş kurallarınız varsa özel yazılım veya WordPress e-ticaret seçeneklerini değerlendiririz.' ),
				array( 'Aylık ücret ödemem gerekir mi?', 'Seçilen altyapıya göre değişir. Bazı hazır altyapılar aylık abonelikle çalışır; bazıları ise yalnızca barındırma ücreti gerektirir. Teklifte tüm tekrarlayan maliyetleri ayrı ayrı yazıyoruz.' ),
				array( 'Pazar yerleriyle entegrasyon mümkün mü?', 'Birçok hazır altyapı, pazar yeri ve muhasebe entegrasyonlarını eklenti veya hazır servislerle destekler. İhtiyaç duyduğunuz entegrasyonları altyapı seçiminden önce birlikte kontrol ediyoruz.' ),
			),
		),
		array(
			'title'   => 'Sıfırdan E-Ticaret Yazılımı',
			'slug'    => 'sifirdan-e-ticaret-yazilimi',
			'icon'    => 'code',
			'label'   => 'Özel E-Ticaret Yazılımı',
			'excerpt' => 'Standart paketlere sığmayan iş modelleri için; bayi, B2B, abonelik veya özel fiyatlama kurallarına göre sıfırdan geliştirilen e-ticaret yazılımı.',
			'seo'     => array( 'Sıfırdan E-Ticaret Yazılımı | B2B ve Özel Çözümler | Akıllı Creative', 'Bayi paneli, B2B sipariş, özel fiyatlama, abonelik ve ERP entegrasyonu gibi ihtiyaçlar için size özel geliştirilen e-ticaret yazılımları.' ),
			'intro'   => array(
				'Bazı işletmelerin satış süreci hazır paketlere sığmaz: bayilere özel fiyat listeleri, onaylı B2B siparişler, ürün yapılandırıcılar, abonelik modelleri, depo veya ERP sistemiyle anlık senkronizasyon gibi. Sıfırdan e-ticaret yazılımında süreçlerinizi önce analiz ediyor, ardından tam olarak bu süreçleri destekleyen bir yazılım geliştiriyoruz.',
				'Kodun ve verinin sahibi sizsiniz. Yazılımı modüler bir mimariyle, belgelenmiş ve test edilmiş şekilde geliştiriyor; ileride yeni özellik eklemek veya ekip değiştirmek istediğinizde sürdürülebilir kalmasını sağlıyoruz. Ödeme tarafında <a href="{home}/hizmetlerimiz/e-ticaret-yazilimi/api-ve-tum-sanal-poslar/">çoklu sanal POS ve API entegrasyonlarını</a> projenin parçası olarak planlıyoruz.',
			),
			'scope'   => array(
				array( 'Süreç analizi ve teknik tasarım', 'Sipariş, fiyatlama, stok ve onay süreçlerinizi belgeleyip yazılım mimarisini tasarlıyoruz.' ),
				array( 'Müşteri ve bayi arayüzleri', 'Perakende müşteriler ve bayiler için ayrı yetkiler, fiyatlar ve ekranlar geliştiriyoruz.' ),
				array( 'Yönetim paneli', 'Ekibinizin günlük işlerine göre tasarlanmış sipariş, ürün, müşteri ve raporlama ekranları.' ),
				array( 'Entegrasyonlar', 'ERP, muhasebe, e-fatura, kargo ve pazar yeri sistemleriyle API üzerinden veri alışverişi.' ),
				array( 'Güvenlik ve ölçeklenebilirlik', 'Rol bazlı yetkilendirme, kayıt (log) tutma, yedekleme ve yük artışına hazır altyapı.' ),
			),
			'for'     => array(
				array( 'B2B ve bayi ağı olan firmalar', 'Bayilerine özel fiyat ve iskonto ile sipariş aldıran üretici ve distribütörler.' ),
				array( 'Özel iş modelleri', 'Abonelik, kiralama, kişiselleştirilmiş ürün veya rezervasyon bazlı satış yapanlar.' ),
				array( 'Paketlerin sınırına gelenler', 'Hazır altyapıda eklenti yığınıyla çalışmaya çalışan, büyümesi yavaşlamış mağazalar.' ),
			),
			'needs'   => array(
				array( 'Manuel sipariş trafiği', 'Telefon ve e-postayla gelen siparişleri bayi panelinden otomatik akışa taşıyoruz.' ),
				array( 'Sistemler arası çift veri girişi', 'Stok, fiyat ve siparişleri ERP veya muhasebe sistemiyle senkronize ediyoruz.' ),
				array( 'Esnemeyen altyapı', 'İş kurallarınızı doğrudan koda dönüştürerek paket sınırlarını ortadan kaldırıyoruz.' ),
			),
			'deliver' => array( 'Süreç analizi ve teknik şartname dokümanı', 'Arayüz tasarımları (müşteri, bayi, yönetici)', 'Kaynak kodu ve kurulum dokümantasyonu', 'Yönetim paneli ve raporlama ekranları', 'Entegrasyon modülleri ve API dokümantasyonu', 'Test senaryoları ve kabul testi', 'Yayın, izleme ve bakım planı' ),
			'process' => array(
				array( 'Keşif ve analiz', 'Paydaşlarla görüşüp süreçleri, kullanıcı rollerini ve entegrasyonları belgeliyoruz.' ),
				array( 'Teknik tasarım ve tahmin', 'Mimariyi, veri modelini ve iş paketlerini çıkarıp aşamalı bir takvim sunuyoruz.' ),
				array( 'Arayüz tasarımı', 'Kritik akışları prototipleyip kullanıcı testleriyle doğruluyoruz.' ),
				array( 'Aşamalı geliştirme', 'Kısa geliştirme döngüleriyle çalışıyor, her aşamada test ortamında demo yapıyoruz.' ),
				array( 'Kabul, yayın ve bakım', 'Kabul testlerinden sonra yayına alıyor, izleme ve bakım sürecini başlatıyoruz.' ),
			),
			'faq'     => array(
				array( 'Kaynak kodun sahibi kim olur?', 'Sözleşmede aksi belirtilmedikçe size özel geliştirilen kodun kullanım hakları size devredilir ve kaynak kod teslim edilir. Kullandığımız açık kaynak kütüphaneleri kendi lisanslarıyla birlikte belgeleriz.' ),
				array( 'Proje bütçesi nasıl belirleniyor?', 'Analiz aşamasında iş paketlerini ve her birinin tahmini eforunu çıkarıyoruz. Büyük projelerde önce temel satış akışını (MVP) yayına alıp sonraki özellikleri aşamalı geliştirmeyi öneriyoruz; böylece yatırım kontrollü ilerler.' ),
				array( 'ERP sistemimizle entegrasyon mümkün mü?', 'ERP sisteminiz bir API, web servisi veya veri aktarım yöntemi sunuyorsa evet. Analiz aşamasında ERP sağlayıcınızın dokümantasyonunu inceleyerek hangi verilerin ne sıklıkla senkronize edileceğini netleştiriyoruz.' ),
			),
		),
		array(
			'title'   => 'WordPress E-Ticaret',
			'slug'    => 'wordpress-e-ticaret',
			'icon'    => 'wordpress',
			'label'   => 'WooCommerce Mağaza',
			'excerpt' => 'WooCommerce ile içerik ve satışı aynı yerde yöneten, esnek, genişletilebilir ve size ait bir online mağaza.',
			'seo'     => array( 'WordPress E-Ticaret (WooCommerce) Sitesi | Akıllı Creative', 'WooCommerce ile esnek, hızlı ve size ait online mağazalar. Sanal POS, kargo, fatura entegrasyonları ve özel geliştirmeler.' ),
			'intro'   => array(
				'WordPress e-ticaret (WooCommerce), içerik üretimi ile satışı aynı platformda birleştirmek isteyen markalar için güçlü bir seçenektir. Blog yazılarınız, kampanya sayfalarınız ve ürünleriniz tek panelden yönetilir; aylık platform aboneliği yerine kendi sunucunuzda çalışan, size ait bir mağazanız olur.',
				'Bu esnekliğin bedeli, doğru kurulmadığında yavaşlayan ve eklenti yığınına dönüşen mağazalardır. Biz WooCommerce mağazalarını hafif bir özel temayla, kontrollü eklenti setiyle ve önbellek/sunucu ayarları yapılmış şekilde kuruyoruz. Ödeme için <a href="{home}/hizmetlerimiz/e-ticaret-yazilimi/sanal-pos-entegrasyonu/">sanal POS entegrasyonunu</a>, kampanya görselleri için <a href="{home}/hizmetlerimiz/grafik-tasarim/afis-ve-banner-tasarimi/">banner tasarımını</a> aynı projede ele alabiliriz.',
			),
			'scope'   => array(
				array( 'WooCommerce kurulumu ve özel tema', 'Mağazanıza özel, performans odaklı WooCommerce teması ve sayfa düzenleri.' ),
				array( 'Ürün yapısı', 'Varyasyonlu ürünler, özellik filtreleri, kategori ve marka yapısını planlıyoruz.' ),
				array( 'Ödeme ve kargo', 'Banka sanal POS’u veya ödeme kuruluşu entegrasyonu, kargo firması ve ücret kuralları.' ),
				array( 'Fatura ve muhasebe', 'E-fatura/e-arşiv ve muhasebe yazılımı entegrasyonları için uygun çözümleri kuruyoruz.' ),
				array( 'Hız ve güvenlik', 'Önbellek, görsel optimizasyonu, güvenlik ayarları ve yedekleme yapılandırması.' ),
			),
			'for'     => array(
				array( 'İçerikle satan markalar', 'Blog, rehber ve kampanya sayfalarıyla müşterisini bilgilendiren işletmeler.' ),
				array( 'Platform bağımsızlığı isteyenler', 'Mağazasının ve verilerinin tamamen kendisine ait olmasını önemseyenler.' ),
				array( 'Mevcut WordPress siteleri', 'Kurumsal WordPress sitesine satış özelliği eklemek isteyenler.' ),
			),
			'needs'   => array(
				array( 'Yavaş WooCommerce mağazası', 'Tema, eklenti ve sunucu tarafında performans iyileştirmesi yapıyoruz.' ),
				array( 'Ödeme hataları', 'Ödeme entegrasyonunu doğru test senaryolarıyla yeniden kuruyoruz.' ),
				array( 'Özel ihtiyaç, uygun eklenti yok', 'Gerekli özelliği WooCommerce standartlarına uygun özel eklentiyle geliştiriyoruz.' ),
			),
			'deliver' => array( 'Özel WooCommerce teması', 'Ürün, kategori ve filtre yapısı', 'Sanal POS / ödeme kuruluşu entegrasyonu', 'Kargo ve teslimat ayarları', 'Yasal sayfalar ve sipariş e-posta şablonları', 'Hız, güvenlik ve yedekleme ayarları', 'Mağaza yönetimi eğitimi' ),
			'process' => array(
				array( 'Mağaza planı', 'Ürünleri, varyasyonları, kampanya kurallarını ve entegrasyonları listeliyoruz.' ),
				array( 'Tasarım', 'Ana sayfa, kategori, ürün, sepet ve ödeme sayfalarını tasarlıyoruz.' ),
				array( 'Geliştirme', 'Temayı ve gerekiyorsa özel eklentileri geliştiriyoruz.' ),
				array( 'Entegrasyon ve test', 'Ödeme, kargo ve fatura entegrasyonlarını test siparişleriyle doğruluyoruz.' ),
				array( 'Yayın ve destek', 'Mağazayı açıyor, ilk haftalarda yakın takip yapıyoruz.' ),
			),
			'faq'     => array(
				array( 'WooCommerce kaç ürüne kadar sorunsuz çalışır?', 'Doğru sunucu, önbellek ve veritabanı ayarlarıyla binlerce ürünlü mağazalar sorunsuz çalışabilir. Performansı belirleyen asıl etkenler barındırma kalitesi, tema ve eklenti seçimidir.' ),
				array( 'Mevcut WordPress siteme mağaza eklenebilir mi?', 'Genellikle evet. Önce mevcut temanızın ve eklentilerinizin WooCommerce ile uyumunu kontrol ediyor, gerekiyorsa tema tarafında düzenleme yapıyoruz.' ),
				array( 'Güncellemeler mağazayı bozar mı?', 'Kontrolsüz güncellemeler sorun yaratabilir. Bakım planımızda güncellemeleri önce test ortamında deniyor, ardından canlı mağazaya uyguluyoruz.' ),
			),
		),
		array(
			'title'   => 'Sanal POS Entegrasyonu',
			'slug'    => 'sanal-pos-entegrasyonu',
			'icon'    => 'card',
			'label'   => 'Sanal POS',
			'excerpt' => 'Bankanızın veya ödeme kuruluşunuzun sanal POS’unu 3D Secure, taksit ve iade süreçleriyle birlikte sitenize güvenle bağlıyoruz.',
			'seo'     => array( 'Sanal POS Entegrasyonu | 3D Secure ve Taksit | Akıllı Creative', 'Banka ve ödeme kuruluşu sanal POS entegrasyonu: 3D Secure, taksit seçenekleri, iade ve iptal akışları. E-ticaret, bağış ve tahsilat sayfaları için.' ),
			'intro'   => array(
				'Sanal POS, kart bilgilerinin güvenle alınıp bankaya iletilmesini ve ödemenin hesabınıza geçmesini sağlayan altyapıdır. Entegrasyon; ödeme formunun güvenli kurulmasını, 3D Secure doğrulamasının doğru işlemesini, taksit seçeneklerinin gösterilmesini ve başarılı/başarısız ödemelerin siparişle doğru eşleşmesini kapsar.',
				'Bankanızla veya bir ödeme kuruluşuyla yaptığınız sözleşme sonrası size verilen bilgilerle entegrasyonu kuruyor, test ortamında tüm senaryoları deniyor ve canlıya alıyoruz. Kart bilgileri sizin sunucunuzda saklanmaz; ödeme sayfası bankanın veya ödeme kuruluşunun güvenli altyapısı üzerinden çalışır. Birden fazla POS kullanmak istiyorsanız <a href="{home}/hizmetlerimiz/e-ticaret-yazilimi/api-ve-tum-sanal-poslar/">çoklu POS ve API entegrasyonu</a> hizmetimize göz atın.',
			),
			'scope'   => array(
				array( '3D Secure ödeme akışı', 'Kartın sahibi tarafından doğrulandığı 3D Secure sürecini doğru yönlendirmelerle kuruyoruz.' ),
				array( 'Taksit ve komisyon ayarları', 'Kart programlarına göre taksit seçeneklerini ve vade farkı gösterimini yapılandırıyoruz.' ),
				array( 'Sipariş eşleştirme', 'Ödeme sonucunun siparişle güvenle eşleşmesini, mükerrer ödemelerin önlenmesini sağlıyoruz.' ),
				array( 'İade ve iptal', 'Panelden iade/iptal işlemlerinin yapılabilmesi için gerekli entegrasyonları kuruyoruz.' ),
				array( 'Hata yönetimi', 'Reddedilen ödemelerde müşteriye anlaşılır mesaj gösteriyor, işlemleri kayıt altına alıyoruz.' ),
			),
			'for'     => array(
				array( 'E-ticaret siteleri', 'Kartla ödeme almak isteyen her ölçekte online mağaza.' ),
				array( 'Hizmet ve tahsilat sayfaları', 'Danışmanlık, eğitim, etkinlik veya aidat tahsilatı yapan işletmeler.' ),
				array( 'Dernek ve vakıflar', 'Online bağış toplamak isteyen kuruluşlar.' ),
			),
			'needs'   => array(
				array( 'Ödemeler alınıyor ama sipariş oluşmuyor', 'Geri dönüş (callback) adımını ve sipariş eşleştirmesini yeniden kuruyoruz.' ),
				array( 'Müşteri 3D ekranında takılıyor', 'Yönlendirmeleri ve mobil uyumluluğu düzeltiyoruz.' ),
				array( 'Taksitler yanlış görünüyor', 'Banka kurallarına göre taksit tablolarını doğru yapılandırıyoruz.' ),
			),
			'deliver' => array( 'Test ortamında doğrulanmış sanal POS entegrasyonu', '3D Secure ödeme akışı', 'Taksit ve vade farkı yapılandırması', 'Başarılı/başarısız ödeme senaryo testleri', 'İade/iptal işlem desteği (altyapı izin veriyorsa)', 'Entegrasyon ve test dokümanı' ),
			'process' => array(
				array( 'Altyapı kontrolü', 'Sitenizin altyapısını ve bankanızın sunduğu entegrasyon yöntemini inceliyoruz.' ),
				array( 'Test bilgileri', 'Bankadan veya ödeme kuruluşundan test ortamı bilgilerini alıyoruz.' ),
				array( 'Entegrasyon', 'Ödeme akışını, taksitleri ve sipariş eşleştirmesini kodluyoruz.' ),
				array( 'Senaryo testleri', 'Başarılı, reddedilen, iptal edilen ve yarıda kalan ödemeleri test ediyoruz.' ),
				array( 'Canlıya geçiş', 'Canlı bilgileri girip gerçek bir işlemle doğruluyor, sonra kontrolü size bırakıyoruz.' ),
			),
			'faq'     => array(
				array( 'Sanal POS’u kimden almalıyım?', 'Çalıştığınız bankadan veya bir ödeme kuruluşundan alabilirsiniz. Bankalar genellikle daha düşük komisyon sunarken ödeme kuruluşları daha hızlı başvuru ve kolay kurulum sağlayabilir. Komisyon, valör (paranın hesaba geçme süresi) ve taksit koşullarını karşılaştırmanızı öneririz.' ),
				array( 'Kart bilgileri sitemde saklanıyor mu?', 'Hayır. Doğru kurulmuş bir entegrasyonda kart bilgileri bankanın veya ödeme kuruluşunun güvenli sayfasında işlenir; siteniz yalnızca işlem sonucunu alır.' ),
				array( 'Entegrasyon ne kadar sürer?', 'Altyapınız hazır ve banka test bilgileri geldiyse genellikle kısa sürede tamamlanır. Süreyi en çok banka başvuru ve onay süreçleri etkiler.' ),
			),
		),
		array(
			'title'   => 'API ve Tüm Sanal POSlar',
			'slug'    => 'api-ve-tum-sanal-poslar',
			'icon'    => 'plug',
			'label'   => 'API ve Çoklu POS',
			'excerpt' => 'Birden fazla banka ve ödeme kuruluşu POS’unu, kargo, fatura, ERP ve pazar yeri API’lerini tek, düzenli bir altyapıda birleştiriyoruz.',
			'seo'     => array( 'Çoklu Sanal POS ve API Entegrasyonu | Akıllı Creative', 'Birden fazla banka ve ödeme kuruluşu POS’u, kargo, e-fatura, ERP ve pazar yeri API entegrasyonları. Akıllı POS yönlendirme ve raporlama.' ),
			'intro'   => array(
				'İşletmeniz büyüdükçe tek bir POS ve elle yürütülen süreçler yetersiz kalır. Farklı bankaların taksit kampanyalarından yararlanmak, bir POS kesintiye uğradığında ödemeyi diğerine yönlendirmek veya kargo, fatura ve stok bilgilerini sistemler arasında otomatik aktarmak istersiniz.',
				'API entegrasyonunda; Türkiye’de yaygın kullanılan banka sanal POS altyapılarını ve ödeme kuruluşlarını, kargo firmalarını, e-fatura sağlayıcılarını, ERP ve muhasebe yazılımlarını sitenize ya da <a href="{home}/hizmetlerimiz/dijital-buyume/ozel-yazilim-cozumleri/">özel yazılımınıza</a> bağlıyoruz. Her entegrasyonu ilgili sağlayıcının resmi dokümantasyonuna göre geliştiriyor, hatalara karşı kayıt tutan ve tekrar deneyen bir yapı kuruyoruz.',
			),
			'scope'   => array(
				array( 'Çoklu POS yönetimi', 'Birden fazla banka/ödeme kuruluşu POS’unu tek panelden yönetme ve karta göre yönlendirme kuralları.' ),
				array( 'Taksit kampanya eşleştirme', 'Kart ailesine göre en uygun taksit seçeneklerinin gösterilmesi.' ),
				array( 'Kargo API’leri', 'Gönderi oluşturma, takip numarası alma ve durum güncellemelerinin otomatik çekilmesi.' ),
				array( 'E-fatura / e-arşiv', 'Siparişlerden otomatik fatura oluşturma için entegratör API bağlantısı.' ),
				array( 'ERP ve muhasebe', 'Ürün, stok, fiyat, cari ve sipariş verilerinin senkronizasyonu.' ),
				array( 'Kayıt ve izleme', 'Her API çağrısının kaydı, hata bildirimleri ve yeniden deneme mekanizması.' ),
			),
			'for'     => array(
				array( 'Yüksek hacimli mağazalar', 'Günlük çok sayıda sipariş işleyen ve kesintiye tahammülü olmayan işletmeler.' ),
				array( 'Çok kanallı satıcılar', 'Web sitesi, pazar yerleri ve bayiler üzerinden aynı stokla satış yapanlar.' ),
				array( 'Operasyonu otomatikleştirmek isteyenler', 'Fatura, kargo ve stok işlerini elle yürütmekten kurtulmak isteyen ekipler.' ),
			),
			'needs'   => array(
				array( 'Tek POS’a bağımlılık', 'Yedek POS ve yönlendirme kurallarıyla ödeme kesintisi riskini azaltıyoruz.' ),
				array( 'Elle girilen faturalar ve kargolar', 'Sipariş onayından sonra fatura ve gönderinin otomatik oluşmasını sağlıyoruz.' ),
				array( 'Uyuşmayan stoklar', 'Kanallar arasında stok senkronizasyonu kurarak fazla satışı önlüyoruz.' ),
			),
			'deliver' => array( 'Entegrasyon envanteri ve veri akış şeması', 'Çoklu POS modülü ve yönlendirme kuralları', 'Kargo, fatura ve ERP bağlantı modülleri', 'Hata kayıtları ve bildirim sistemi', 'Yönetim panelinde entegrasyon durum ekranı', 'Teknik dokümantasyon' ),
			'process' => array(
				array( 'Envanter çıkarma', 'Kullandığınız tüm sistemleri ve aralarındaki veri akışını listeliyoruz.' ),
				array( 'Dokümantasyon incelemesi', 'Her sağlayıcının API dokümanını ve test ortamını inceliyoruz.' ),
				array( 'Geliştirme', 'Entegrasyonları ortak bir yapı üzerinde, kayıt ve hata yönetimiyle geliştiriyoruz.' ),
				array( 'Uçtan uca test', 'Siparişten faturaya kadar tüm akışı test ortamlarında deniyoruz.' ),
				array( 'Canlıya geçiş ve izleme', 'Aşamalı olarak canlıya alıyor, ilk dönemde yakından izliyoruz.' ),
			),
			'faq'     => array(
				array( 'Hangi bankalarla ve ödeme kuruluşlarıyla çalışabiliyorsunuz?', 'Teknik olarak, entegrasyon dokümantasyonu ve test ortamı sunan banka ve ödeme kuruluşlarının büyük çoğunluğuyla entegrasyon yapabiliyoruz. Kullanmak istediğiniz sağlayıcıları ilk görüşmede paylaşırsanız uygunluğunu kontrol edip net bilgi veririz.' ),
				array( 'Bir entegrasyon çalışmayı bırakırsa ne olur?', 'Hata durumları kayıt altına alınır, yöneticilere bildirim gider ve uygun durumlarda işlem otomatik olarak yeniden denenir. Sağlayıcı tarafındaki değişikliklere karşı bakım desteği öneriyoruz.' ),
				array( 'Pazar yeri entegrasyonu yapıyor musunuz?', 'Pazar yerlerinin satıcılara sunduğu API’ler üzerinden ürün, stok ve sipariş entegrasyonu geliştirebiliyoruz. Hazır entegratör hizmetlerinin daha uygun olduğu durumlarda bunu da açıkça belirtiyoruz.' ),
			),
		),
		array(
			'title'   => 'Yeni Özellik Ekleme (PHP)',
			'slug'    => 'yeni-ozellik-ekleme-php',
			'icon'    => 'gear',
			'label'   => 'Özellik Geliştirme (PHP)',
			'excerpt' => 'Mevcut PHP tabanlı sitenize veya e-ticaret yazılımınıza; yeni modül, rapor, entegrasyon ya da iyileştirme ekliyor, eski kodu güvenle düzenliyoruz.',
			'seo'     => array( 'PHP ile Yeni Özellik Ekleme ve Geliştirme | Akıllı Creative', 'Mevcut PHP, WordPress, WooCommerce veya özel yazılımınıza yeni modül, rapor ve entegrasyon ekliyoruz. Kod incelemesi, hata düzeltme ve iyileştirme.' ),
			'intro'   => array(
				'Çalışan bir siteniz var ama yeni bir ihtiyaç doğdu: özel bir indirim kuralı, bayi raporu, toplu ürün güncelleme ekranı ya da yeni bir ödeme yöntemi. Siteyi baştan yaptırmak yerine mevcut yapıya bu özelliği doğru şekilde eklemek çoğu zaman daha hızlı ve ekonomiktir.',
				'PHP ile yazılmış özel yazılımlar, WordPress/WooCommerce siteleri ve PHP framework’leriyle (ör. Laravel) geliştirilmiş projelerde çalışıyoruz. İşe her zaman kod incelemesiyle başlıyor, mevcut yapıyı bozmayacak, güncellemelerde kaybolmayacak ve belgelenmiş bir yöntem seçiyoruz. Değişiklikleri önce test ortamında deniyor, yedek alarak canlıya taşıyoruz.',
			),
			'scope'   => array(
				array( 'Kod ve altyapı incelemesi', 'Mevcut kodun yapısını, PHP sürümünü, güvenlik durumunu ve riskli noktalarını raporluyoruz.' ),
				array( 'Yeni modül geliştirme', 'İhtiyacınız olan özelliği mevcut mimariye uygun, güncellemelere dayanıklı şekilde ekliyoruz.' ),
				array( 'Raporlama ve yönetim ekranları', 'Ekibinizin ihtiyaç duyduğu özel rapor, dışa aktarma ve toplu işlem ekranları.' ),
				array( 'Hata düzeltme ve performans', 'Yavaş sorguları, hata veren sayfaları ve güvenlik açıklarını gideriyoruz.' ),
				array( 'Sürüm yükseltme', 'Eski PHP sürümlerinden güncel sürüme geçiş için uyumluluk düzenlemeleri.' ),
			),
			'for'     => array(
				array( 'Yazılımcısı ayrılan firmalar', 'Geliştiricisine ulaşamadığı bir sistemi devam ettirmek zorunda kalanlar.' ),
				array( 'Büyüyen e-ticaret siteleri', 'Mevcut altyapısını koruyarak yeni özellikler eklemek isteyen mağazalar.' ),
				array( 'Kurum içi yazılım kullananlar', 'PHP ile yazılmış iç sistemlerine modül eklemek isteyen işletmeler.' ),
			),
			'needs'   => array(
				array( 'Kimse koda dokunmaya cesaret edemiyor', 'Önce inceleme ve yedekleme yapıp, değişiklikleri test ortamında güvenle uyguluyoruz.' ),
				array( 'Özellik eksikliği satışı yavaşlatıyor', 'İhtiyacı netleştirip en az değişiklikle en çok faydayı sağlayan çözümü geliştiriyoruz.' ),
				array( 'Eski PHP sürümü', 'Güvenlik ve performans için güncel sürüme kontrollü geçişi planlıyoruz.' ),
			),
			'deliver' => array( 'Kod inceleme raporu ve risk listesi', 'İş tanımı ve tahmini efor', 'Test ortamında doğrulanmış geliştirme', 'Yedekli canlıya geçiş', 'Değişiklik notları ve teknik doküman', 'Yayın sonrası kontrol süreci' ),
			'process' => array(
				array( 'İhtiyacı anlamak', 'Eklenecek özelliğin iş kuralını ve beklenen sonucu netleştiriyoruz.' ),
				array( 'Kod incelemesi', 'Erişim bilgileriyle mevcut yapıyı inceleyip risklerini paylaşıyoruz.' ),
				array( 'Teklif ve plan', 'Kapsamı, süreyi ve ücreti yazılı olarak sunuyoruz.' ),
				array( 'Geliştirme ve test', 'Test ortamında geliştirip sizin onayınıza sunuyoruz.' ),
				array( 'Canlıya alma', 'Yedek alıp değişikliği canlıya taşıyor ve izliyoruz.' ),
			),
			'faq'     => array(
				array( 'Başka bir ekibin yazdığı koda müdahale ediyor musunuz?', 'Evet. Önce kodu inceleyip mevcut durumu açıkça raporluyoruz. Kodun yapısı izin verdiği ölçüde mevcut mimariye uygun geliştirme yapıyor; çok riskli durumlarda alternatifleri anlatıyoruz.' ),
				array( 'Küçük işler için de çalışıyor musunuz?', 'Evet. Tek bir hata düzeltmesi veya küçük bir özellik eklemesi de yapabiliriz. Sık küçük ihtiyaçlarınız varsa aylık geliştirme saati paketi daha ekonomik olabilir.' ),
				array( 'Canlı siteyi bozma riskiniz var mı?', 'Riski en aza indirmek için değişiklikleri önce kopyalanmış bir test ortamında yapıyor, canlıya geçmeden tam yedek alıyoruz. Sorun çıkarsa önceki duruma hızla dönülebilir.' ),
			),
		),
	),
);
