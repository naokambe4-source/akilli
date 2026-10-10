<?php
/**
 * Demo content: Grafik Tasarım category.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'    => 'Grafik Tasarım',
	'slug'     => 'grafik-tasarim',
	'icon'     => 'pen',
	'excerpt'  => 'Logodan kurumsal kimliğe, basılı materyallerden dijital arayüzlere kadar markanızın her temas noktasında tutarlı ve akılda kalan bir görsel dil kuruyoruz.',
	'seo'      => array( 'Grafik Tasarım Hizmetleri | Logo, Kimlik, UX/UI | Akıllı Creative', 'Logo, kurumsal kimlik, kartvizit, afiş-banner, UX/UI ve Figma tasarım hizmetleri. Antalya merkezli ekipten tutarlı ve özgün marka tasarımı.' ),
	'intro'    => array(
		'İyi bir tasarım güzel görünmenin ötesinde bir iş yapar: markanızı tanınır kılar, mesajınızı netleştirir ve müşterinin karar vermesini kolaylaştırır. Grafik tasarım hizmetlerimizde her işi, markanızın genel görsel sistemiyle uyumlu olacak şekilde ele alıyoruz.',
		'Basılı materyallerde baskı tekniklerini, dijital işlerde ise ekran boyutlarını ve kullanılabilirliği gözeterek çalışıyoruz. Teslim ettiğimiz tüm dosyalar düzenli, isimlendirilmiş ve tekrar kullanılabilir olur.',
	),
	'common'   => array(
		'Markanıza özgü, sıfırdan üretilmiş tasarımlar',
		'Lisans durumu net görsel ve yazı tipi kullanımı',
		'Baskıya hazır (CMYK, taşma payı) ve dijitale hazır (RGB, SVG/PNG) dosyalar',
		'Kaynak dosyalar (AI, PDF, Figma) ve düzenli klasör yapısı',
		'Makul sayıda revizyon hakkı ve net onay süreci',
		'Kullanım kılavuzu veya stil özeti',
	),
	'faq'      => array(
		array( 'Kaynak dosyaları teslim ediyor musunuz?', 'Evet. Proje tamamlandığında düzenlenebilir kaynak dosyaları ve kullanıma hazır çıktı formatlarını teslim ediyoruz. Kullanılan yazı tiplerinin lisans bilgisini de paylaşıyoruz.' ),
		array( 'Kaç revizyon hakkım var?', 'Revizyon sayısı teklifte açıkça yazılır. Revizyonları toplu ve net geri bildirimlerle iletmeniz süreci hızlandırır; bunun için size basit bir geri bildirim şablonu veriyoruz.' ),
		array( 'Baskı işini de siz mi yaptırıyorsunuz?', 'Tasarımı baskıya hazır hale getiriyoruz. İsterseniz çalıştığınız matbaayla koordinasyonu üstlenebilir, prova kontrolünde destek olabiliriz.' ),
	),
	'children' => array(
		array(
			'title'   => 'Kurumsal Kimlik Tasarımı',
			'slug'    => 'kurumsal-kimlik-tasarimi',
			'icon'    => 'layers',
			'label'   => 'Kurumsal Kimlik',
			'excerpt' => 'Logo, renk, tipografi, görsel dil ve uygulama kurallarını bir araya getiren; markanızın her yerde aynı görünmesini sağlayan kimlik sistemi.',
			'seo'     => array( 'Kurumsal Kimlik Tasarımı | Marka Kılavuzu | Akıllı Creative', 'Logo, renk paleti, tipografi, görsel dil ve kurumsal kimlik kılavuzu. Kartvizitten web sitesine tutarlı bir marka görünümü.' ),
			'intro'   => array(
				'Kurumsal kimlik, logonuzun etrafında kurulan bütün sistemdir: hangi renkleri hangi oranda kullandığınız, başlıklarda ve metinlerde hangi yazı tiplerini tercih ettiğiniz, fotoğraf ve ikonların nasıl görünmesi gerektiği, sosyal medya şablonlarından antetli kâğıda kadar her uygulamanın kuralları.',
				'İyi kurulmuş bir kimlik sistemi, ekibinizdeki farklı kişilerin ya da farklı ajansların ürettiği işlerin bile aynı markadan çıktığını belli eder. Kimlik çalışmasını genellikle <a href="{home}/hizmetlerimiz/grafik-tasarim/logo-tasarimi/">logo tasarımıyla</a> birlikte ele alıyor, sonucu yeni <a href="{home}/hizmetlerimiz/web-tasarim/kurumsal-web-tasarimi/">kurumsal web sitenize</a> doğrudan taşıyabiliyoruz.',
			),
			'scope'   => array(
				array( 'Marka keşfi', 'Markanızın değerlerini, kişiliğini, hedef kitlesini ve rakiplerin görsel dilini analiz ediyoruz.' ),
				array( 'Renk ve tipografi sistemi', 'Ekranda ve baskıda tutarlı çalışan renk paleti ve yazı tipi hiyerarşisi oluşturuyoruz.' ),
				array( 'Görsel dil', 'Fotoğraf yönü, ikon seti, desen ve grafik ögelerle markaya özgü bir anlatım geliştiriyoruz.' ),
				array( 'Kurumsal uygulamalar', 'Kartvizit, antetli kâğıt, zarf, e-posta imzası, sunum ve sosyal medya şablonları.' ),
				array( 'Kimlik kılavuzu', 'Tüm kuralları örneklerle anlatan, ekibinizin ve tedarikçilerinizin kullanabileceği kılavuz.' ),
			),
			'for'     => array(
				array( 'Yeni kurulan markalar', 'İşe doğru ve tutarlı bir görünümle başlamak isteyen girişimler.' ),
				array( 'Yenilenen markalar', 'Büyüyen, birleşen veya hizmet alanını genişleten firmalar.' ),
				array( 'Dağınık görünen markalar', 'Her materyali farklı görünen, tanınırlığı zayıf işletmeler.' ),
			),
			'needs'   => array(
				array( 'Her materyal farklı görünüyor', 'Tüm uygulamaları tek bir sisteme bağlayan kurallar tanımlıyoruz.' ),
				array( 'Marka olduğundan küçük görünüyor', 'Profesyonel ve güven veren bir görsel dil kuruyoruz.' ),
				array( 'Tasarım işleri hep baştan yapılıyor', 'Şablonlar ve kılavuzla ekibinizin hızlıca üretmesini sağlıyoruz.' ),
			),
			'deliver' => array( 'Marka keşif özeti', 'Logo ve varyasyonları (yatay, dikey, ikon, tek renk)', 'Renk paleti (HEX, RGB, CMYK, Pantone karşılıkları)', 'Tipografi sistemi', 'Kartvizit, antetli kâğıt, zarf ve e-posta imzası', 'Sunum ve sosyal medya şablonları', 'Kurumsal kimlik kılavuzu (PDF)', 'Düzenli kaynak dosyalar' ),
			'process' => array(
				array( 'Keşif atölyesi', 'Markanızı, hedeflerinizi ve beğendiğiniz/beğenmediğiniz örnekleri konuşuyoruz.' ),
				array( 'Strateji ve moodboard', 'Görsel yönü belirleyen moodboard ve ilkeleri sunuyoruz.' ),
				array( 'Tasarım önerileri', 'Kimlik önerilerini gerçek uygulama örnekleri üzerinde gösteriyoruz.' ),
				array( 'Geliştirme ve uygulamalar', 'Seçilen yönü tüm materyallere uyguluyoruz.' ),
				array( 'Kılavuz ve teslim', 'Kılavuzu hazırlayıp tüm dosyaları düzenli şekilde teslim ediyoruz.' ),
			),
			'faq'     => array(
				array( 'Mevcut logomuzu koruyarak kimlik çalışması yapılabilir mi?', 'Evet. Logonuz güçlü ve tanınırsa koruyup çevresindeki sistemi (renk, tipografi, görsel dil) yeniden kurabiliriz. Gerekirse logoda küçük iyileştirmeler (sadeleştirme, okunurluk) öneririz.' ),
				array( 'Kimlik kılavuzu neden önemli?', 'Kılavuz, markanızın ajans veya çalışan değişse bile aynı görünmesini sağlar. Matbaa, tabelacı ya da sosyal medya ekibi gibi tedarikçilere net kurallar verir.' ),
				array( 'Kimlik çalışması ne kadar sürer?', 'Kapsama göre değişir. Keşif, tasarım, revizyon ve uygulama aşamalarının takvimini teklifte paylaşıyoruz; en çok zaman alan kısım genellikle karar ve onay süreçleridir.' ),
			),
		),
		array(
			'title'   => 'Logo Tasarımı',
			'slug'    => 'logo-tasarimi',
			'icon'    => 'spark',
			'label'   => 'Logo',
			'excerpt' => 'Markanızı tek bakışta anlatan, küçük boyutta da okunabilen, farklı zeminlerde tutarlı çalışan özgün logolar.',
			'seo'     => array( 'Logo Tasarımı | Özgün ve Ölçeklenebilir | Akıllı Creative', 'Markanıza özgü, farklı boyut ve zeminlerde okunabilir logo tasarımı. Varyasyonlar, renk sürümleri ve vektörel kaynak dosyalarla teslim.' ),
			'intro'   => array(
				'Logo; tabelada, web sitesinin köşesinde, telefon ekranındaki bir uygulama simgesinde veya bir kalemin üzerinde aynı markayı anlatabilmelidir. Bu yüzden logoyu yalnızca büyük bir ekranda güzel görünecek şekilde değil, en küçük kullanımda da okunacak şekilde tasarlıyoruz.',
				'Hazır ikon kütüphanelerinden veya yapay zekâ üretimi şablonlardan derlenmiş logolar yerine markanız için sıfırdan çizilmiş, tescil başvurusuna uygun özgün işaretler üretiyoruz. Logonuzu bütünlüklü bir sisteme dönüştürmek isterseniz <a href="{home}/hizmetlerimiz/grafik-tasarim/kurumsal-kimlik-tasarimi/">kurumsal kimlik tasarımı</a> ile devam edebiliriz.',
			),
			'scope'   => array(
				array( 'Araştırma', 'Sektörünüzdeki logoları inceleyip benzerlikten kaçınacak, ayırt edici bir yön belirliyoruz.' ),
				array( 'Eskiz ve konsept', 'Farklı fikirleri eskiz aşamasında deneyip en güçlü konseptleri dijitale taşıyoruz.' ),
				array( 'Vektörel çizim', 'Seçilen konsepti oran, denge ve okunurluk açısından inceltip vektörel olarak çiziyoruz.' ),
				array( 'Varyasyonlar', 'Yatay, dikey, sadece işaret ve tek renk sürümler hazırlıyoruz.' ),
				array( 'Kullanım testleri', 'Logoyu favicon, kartvizit, tabela ve sosyal medya profilinde test ediyoruz.' ),
			),
			'for'     => array(
				array( 'Yeni işletmeler', 'Markasını ilk kez oluşturan girişimler ve esnaf.' ),
				array( 'Logosu eskimiş markalar', 'Dijitalde okunurluğu zayıf, karmaşık logolara sahip firmalar.' ),
				array( 'Alt markalar', 'Yeni ürün, hizmet veya şube için kardeş marka oluşturan işletmeler.' ),
			),
			'needs'   => array(
				array( 'Küçük boyutta okunmuyor', 'Sade formlar ve doğru boşluklarla her boyutta okunurluğu sağlıyoruz.' ),
				array( 'Rakiplere benziyor', 'Sektör araştırmasıyla ayırt edici bir işaret tasarlıyoruz.' ),
				array( 'Dosyası yok, bulanık', 'Vektörel kaynak dosyalarla her ölçekte net kullanım imkânı veriyoruz.' ),
			),
			'deliver' => array( 'Logo konsept sunumu', 'Ana logo ve varyasyonları', 'Renkli, tek renk ve negatif sürümler', 'Vektörel (AI, SVG, PDF) ve bitmap (PNG) dosyalar', 'Favicon ve sosyal medya profil görselleri', 'Kısa logo kullanım rehberi' ),
			'process' => array(
				array( 'Brif', 'Markanızın adı, hikâyesi, hedef kitlesi ve beklentilerinizi dinliyoruz.' ),
				array( 'Araştırma ve eskiz', 'Sektör taraması yapıp farklı fikirleri eskizle deniyoruz.' ),
				array( 'Konsept sunumu', 'Seçilmiş konseptleri uygulama örnekleriyle sunuyoruz.' ),
				array( 'Revizyon', 'Geri bildirimlerinize göre seçilen konsepti geliştiriyoruz.' ),
				array( 'Teslim', 'Tüm varyasyonları ve dosya formatlarını teslim ediyoruz.' ),
			),
			'faq'     => array(
				array( 'Logomu marka tescili için kullanabilir miyim?', 'Özgün olarak tasarladığımız logolar tescil başvurusu için uygundur. Başvuru öncesinde benzer marka araştırmasını bir marka vekili aracılığıyla yaptırmanızı öneririz; tescilin kabulü ilgili kurumun değerlendirmesine bağlıdır.' ),
				array( 'Kaç farklı logo önerisi sunuyorsunuz?', 'Sayıdan çok kaliteye odaklanıyoruz. Genellikle güçlü bulduğumuz birkaç konsepti uygulama örnekleriyle sunuyoruz; kesin sayı teklifte belirtilir.' ),
				array( 'Logonun telif hakları kime ait olur?', 'Ödeme tamamlandığında seçilen logonun kullanım hakları size devredilir. Bu konu sözleşmede açıkça yazılır.' ),
			),
		),
		array(
			'title'   => 'Kartvizit Tasarımı',
			'slug'    => 'kartvizit-tasarimi',
			'icon'    => 'id',
			'label'   => 'Kartvizit',
			'excerpt' => 'Kurumsal kimliğinizle uyumlu, okunaklı ve baskı tekniği doğru seçilmiş; elde tutulduğunda markanızı hissettiren kartvizitler.',
			'seo'     => array( 'Kartvizit Tasarımı | Baskıya Hazır | Akıllı Creative', 'Kurumsal kimliğinize uygun, okunaklı ve baskı tekniği doğru planlanmış kartvizit tasarımı. Ekip için düzenlenebilir şablon ve QR kod seçeneği.' ),
			'intro'   => array(
				'Kartvizit, dijital çağda bile ilk yüz yüze görüşmede markanızın elde kalan tek parçasıdır. Kâğıdın dokusu, baskının kalitesi ve bilgilerin düzeni, karşınızdakinin sizi nasıl hatırlayacağını etkiler.',
				'Kartvizit tasarımında önce bilgi hiyerarşisini kuruyor (ad, unvan, iletişim), ardından kâğıt, gramaj ve baskı tekniğiyle birlikte düşünülmüş bir tasarım hazırlıyoruz. Birden fazla çalışanınız varsa yeni isimleri hızla ekleyebileceğiniz bir şablon da teslim ediyoruz. Kartvizitiniz <a href="{home}/hizmetlerimiz/grafik-tasarim/kurumsal-kimlik-tasarimi/">kurumsal kimliğinizin</a> diğer parçalarıyla tutarlı olur.',
			),
			'scope'   => array(
				array( 'Bilgi düzeni', 'Hangi bilgilerin yer alacağını ve okunma sırasını belirliyoruz.' ),
				array( 'Ön ve arka yüz tasarımı', 'Kimliğinize uygun iki yüz tasarımı ve isteğe bağlı QR kod (vCard veya web adresi).' ),
				array( 'Baskı danışmanlığı', 'Kâğıt türü, gramaj, selefon, lak veya yaldız gibi seçenekler için öneriler.' ),
				array( 'Ekip şablonu', 'Yeni çalışanlar için kolayca düzenlenebilen kartvizit şablonu.' ),
			),
			'for'     => array(
				array( 'Satış ve saha ekipleri', 'Müşteriyle yüz yüze görüşen ekipler.' ),
				array( 'Serbest çalışanlar', 'Kişisel markasını güçlendirmek isteyen profesyoneller.' ),
				array( 'Fuar ve etkinlik katılımcıları', 'Kısa sürede çok sayıda kişiyle tanışan firmalar.' ),
			),
			'needs'   => array(
				array( 'Kalabalık ve okunmayan kart', 'Bilgileri sadeleştirip net bir hiyerarşi kuruyoruz.' ),
				array( 'Baskıda renkler farklı çıkıyor', 'Dosyaları baskıya uygun renk profili ve taşma paylarıyla hazırlıyoruz.' ),
				array( 'Her çalışan için ayrı tasarım', 'Tek şablonla tutarlı ve hızlı üretim sağlıyoruz.' ),
			),
			'deliver' => array( 'Ön ve arka yüz kartvizit tasarımı', 'Baskıya hazır PDF (CMYK, taşma paylı)', 'Ekip için düzenlenebilir şablon', 'QR kod (isteğe bağlı)', 'Kâğıt ve baskı önerileri' ),
			'process' => array(
				array( 'Bilgilerin toplanması', 'Kartta yer alacak bilgileri ve kişileri netleştiriyoruz.' ),
				array( 'Tasarım', 'Kimliğinize uygun tasarım önerilerini hazırlıyoruz.' ),
				array( 'Revizyon ve onay', 'Geri bildirimlere göre son hali onayınıza sunuyoruz.' ),
				array( 'Baskı dosyası', 'Baskıya hazır dosyaları ve şablonu teslim ediyoruz.' ),
			),
			'faq'     => array(
				array( 'Kartvizite QR kod eklemeli miyim?', 'Kişi bilgilerinizi telefona kaydettiren bir vCard QR kodu veya web sitenize yönlendiren bir kod pratik olabilir. Kodun çalıştığını baskıdan önce test ediyoruz.' ),
				array( 'Logom yok, kartvizit yaptırabilir miyim?', 'Yaptırabilirsiniz; ancak kartvizit markanın ilk uygulamalarından biri olduğu için önce basit bir logo veya yazı karakteri tabanlı bir marka işareti oluşturmanızı öneririz.' ),
				array( 'Baskıyı siz mi yaptırıyorsunuz?', 'Baskıya hazır dosyayı teslim ediyoruz. İsterseniz matbaa seçimi ve prova kontrolünde destek oluyoruz.' ),
			),
		),
		array(
			'title'   => 'Afiş ve Banner Tasarımı',
			'slug'    => 'afis-ve-banner-tasarimi',
			'icon'    => 'image',
			'label'   => 'Afiş ve Banner',
			'excerpt' => 'Kampanya, etkinlik ve ürün duyurularınız için; sokakta, mağazada ve ekranda dikkat çeken, mesajını saniyeler içinde anlatan afiş ve banner tasarımları.',
			'seo'     => array( 'Afiş ve Banner Tasarımı | Kampanya Görselleri | Akıllı Creative', 'Kampanya, etkinlik ve ürün duyuruları için afiş, roll-up, web banner ve sosyal medya görselleri. Tüm boyutlara uyarlanmış, baskıya ve dijitale hazır.' ),
			'intro'   => array(
				'Bir afiş veya banner’ın çoğu zaman yalnızca birkaç saniyesi vardır: yoldan geçen birinin, sosyal medyada kaydıran birinin veya web sitesinde gezinen birinin dikkatini çekip mesajı iletmesi gerekir. Bu yüzden tek bir ana mesaj, net bir görsel odak ve açık bir çağrı üzerine kuruyoruz.',
				'Kampanya görsellerini genellikle bir set olarak tasarlıyoruz: ana kampanya görseli; afiş, roll-up, web sitesi banner’ları, <a href="{home}/hizmetlerimiz/dijital-buyume/dijital-reklam-yonetimi/">dijital reklam</a> ölçüleri ve sosyal medya formatlarına uyarlanır. Böylece kampanyanız her kanalda aynı görünür.',
			),
			'scope'   => array(
				array( 'Kampanya ana görseli', 'Mesajı ve görsel fikri belirleyen ana tasarım.' ),
				array( 'Basılı uyarlamalar', 'Afiş, poster, roll-up, branda, el ilanı ve vitrin görselleri.' ),
				array( 'Dijital uyarlamalar', 'Web sitesi slider ve banner’ları, e-posta görselleri, dijital reklam ölçüleri.' ),
				array( 'Sosyal medya setleri', 'Gönderi, hikâye ve kapak görselleri için uyarlanmış formatlar.' ),
				array( 'Hareketli versiyonlar', 'İsteğe bağlı kısa animasyonlu banner ve hikâye videoları.' ),
			),
			'for'     => array(
				array( 'Perakende ve e-ticaret', 'Sezon, indirim ve yeni ürün kampanyası yapan markalar.' ),
				array( 'Etkinlik düzenleyenler', 'Konser, seminer, fuar ve lansman organizatörleri.' ),
				array( 'Turizm ve yeme-içme', 'Sezonluk duyurular yapan otel, restoran ve kafeler.' ),
			),
			'needs'   => array(
				array( 'Kalabalık ve okunmayan görseller', 'Tek bir ana mesaja odaklanan sade kompozisyonlar kuruyoruz.' ),
				array( 'Her kanalda farklı görünen kampanya', 'Tek bir ana görselden tutarlı bir format seti üretiyoruz.' ),
				array( 'Yanlış ölçüde dosyalar', 'Her mecranın teknik gereksinimine uygun dosyalar teslim ediyoruz.' ),
			),
			'deliver' => array( 'Kampanya ana görseli', 'Baskı için uyarlamalar (taşma paylı PDF)', 'Web banner ve slider görselleri (WebP/PNG/JPG)', 'Sosyal medya format seti', 'İsteğe bağlı hareketli versiyonlar', 'Düzenlenebilir kaynak dosyalar' ),
			'process' => array(
				array( 'Brif', 'Kampanyanın amacını, mesajını, tarihlerini ve kanallarını netleştiriyoruz.' ),
				array( 'Ana görsel', 'Ana kampanya görselini tasarlayıp onayınıza sunuyoruz.' ),
				array( 'Uyarlamalar', 'Onaylanan görseli tüm format ve ölçülere uyarlıyoruz.' ),
				array( 'Teslim', 'Baskı ve dijital dosyaları düzenli şekilde teslim ediyoruz.' ),
			),
			'faq'     => array(
				array( 'Stok fotoğraf kullanıyor musunuz?', 'Gerekirse lisanslı stok fotoğraf veya çizim kullanıyoruz ve lisans bilgisini paylaşıyoruz. Mümkünse markanıza ait çekimlerin kullanılmasını öneriyoruz.' ),
				array( 'Acil kampanyalar için ne kadar sürede çalışabilirsiniz?', 'İş yoğunluğumuza ve kapsamına göre değişir. Kampanya tarihini ilk mesajınızda belirtirseniz takvimi buna göre planlıyoruz.' ),
				array( 'Görselleri kendimiz güncelleyebilir miyiz?', 'Fiyat veya tarih gibi değişken bilgiler için kolay düzenlenebilir şablonlar (ör. Figma veya Canva uyumlu) hazırlayabiliriz.' ),
			),
		),
		array(
			'title'   => 'UX / UI Tasarımı',
			'slug'    => 'ux-ui-tasarimi',
			'icon'    => 'figma',
			'label'   => 'UX / UI',
			'excerpt' => 'Web siteleri, paneller ve mobil uygulamalar için; kullanıcının ne yapacağını düşünmeden anladığı, araştırma ve testle desteklenen arayüz tasarımı.',
			'seo'     => array( 'UX / UI Tasarımı | Kullanıcı Deneyimi ve Arayüz | Akıllı Creative', 'Web, panel ve mobil uygulamalar için kullanıcı deneyimi (UX) ve arayüz (UI) tasarımı. Kullanıcı akışları, prototip, tasarım sistemi ve kullanılabilirlik testleri.' ),
			'intro'   => array(
				'UX (kullanıcı deneyimi) tasarımı, kullanıcının bir işi ne kadar kolay tamamladığıyla ilgilenir: bir ürünü bulmak, bir formu doldurmak, bir raporu okumak. UI (kullanıcı arayüzü) tasarımı ise bu deneyimin ekranda nasıl göründüğünü belirler. İkisi birlikte düşünülmediğinde ya güzel ama kullanışsız ya da kullanışlı ama itici arayüzler ortaya çıkar.',
				'Çalışmaya kullanıcılarınızı ve onların amaçlarını anlamakla başlıyor, akışları ve tel çerçeveleri (wireframe) hazırlıyor, prototip üzerinde test edip ardından görsel tasarıma geçiyoruz. Tasarımı geliştiricilerin doğrudan uygulayabileceği bir <a href="{home}/hizmetlerimiz/grafik-tasarim/psd-figma-tasarimi/">Figma tasarım sistemiyle</a> teslim ediyor; isterseniz <a href="{home}/hizmetlerimiz/dijital-buyume/ozel-yazilim-cozumleri/">yazılım geliştirmesini</a> de üstleniyoruz.',
			),
			'scope'   => array(
				array( 'Kullanıcı ve ihtiyaç analizi', 'Kullanıcı tipleri, amaçları ve mevcut sorunlar üzerine görüşme ve analiz.' ),
				array( 'Bilgi mimarisi ve akışlar', 'Ekranların ilişkisi ve kullanıcının adım adım izleyeceği yollar.' ),
				array( 'Wireframe ve prototip', 'Görsel tasarımdan önce yapıyı test etmeye yarayan tıklanabilir prototipler.' ),
				array( 'Arayüz (UI) tasarımı', 'Markaya uygun, erişilebilir renk ve tipografiyle detaylı ekran tasarımları.' ),
				array( 'Tasarım sistemi', 'Buton, form, kart, tablo gibi yeniden kullanılabilir bileşen kütüphanesi.' ),
				array( 'Kullanılabilirlik testi', 'Gerçek kullanıcılarla küçük ölçekli testler ve iyileştirme önerileri.' ),
			),
			'for'     => array(
				array( 'Yazılım ve SaaS ürünleri', 'Panel, uygulama veya platform geliştiren ekipler.' ),
				array( 'E-ticaret siteleri', 'Sepet terk oranını ve satın alma akışını iyileştirmek isteyen mağazalar.' ),
				array( 'Kurum içi sistemler', 'Çalışanların her gün kullandığı karmaşık iç uygulamalar.' ),
			),
			'needs'   => array(
				array( 'Kullanıcılar nerede takıldığını söylemiyor', 'Analiz ve testlerle sorun noktalarını görünür kılıyoruz.' ),
				array( 'Her ekran farklı görünüyor', 'Tasarım sistemiyle tutarlı bir arayüz dili kuruyoruz.' ),
				array( 'Tasarım ve yazılım ekibi anlaşamıyor', 'Geliştiriciye hazır, belgelenmiş bileşenler teslim ediyoruz.' ),
			),
			'deliver' => array( 'Kullanıcı akışları ve site/uygulama haritası', 'Wireframe’ler', 'Tıklanabilir prototip', 'Masaüstü ve mobil ekran tasarımları', 'Figma tasarım sistemi ve bileşen kütüphanesi', 'Kullanılabilirlik test notları', 'Geliştirici teslim dokümanı' ),
			'process' => array(
				array( 'Keşif', 'Kullanıcıları, iş hedeflerini ve teknik kısıtları anlıyoruz.' ),
				array( 'Yapı', 'Bilgi mimarisini, akışları ve wireframe’leri hazırlıyoruz.' ),
				array( 'Prototip ve test', 'Kritik akışları prototipleyip kullanıcılarla test ediyoruz.' ),
				array( 'Görsel tasarım', 'Arayüzü ve tasarım sistemini oluşturuyoruz.' ),
				array( 'Teslim ve destek', 'Geliştiricilere teslim ediyor, uygulama sürecinde destek veriyoruz.' ),
			),
			'faq'     => array(
				array( 'UX çalışması küçük projeler için gerekli mi?', 'Ölçeği küçültülebilir. Küçük projelerde bile ana kullanıcı akışlarını ve kritik ekranları baştan düşünmek, sonradan yapılacak maliyetli değişiklikleri azaltır.' ),
				array( 'Kullanıcı testlerini nasıl yapıyorsunuz?', 'Hedef kitlenize uygun az sayıda katılımcıyla, prototip üzerinde belirli görevleri yapmalarını isteyerek gözlem yapıyoruz. Sonuçları somut iyileştirme önerilerine dönüştürüyoruz.' ),
				array( 'Tasarımı başka bir yazılım ekibine verebilir miyiz?', 'Evet. Figma dosyaları, bileşen kütüphanesi ve teslim dokümanı herhangi bir geliştirme ekibinin kullanabileceği şekilde hazırlanır.' ),
			),
		),
		array(
			'title'   => 'PSD / Figma Tasarımı',
			'slug'    => 'psd-figma-tasarimi',
			'icon'    => 'figma',
			'label'   => 'Figma / PSD',
			'excerpt' => 'Kendi yazılım ekibiniz veya başka bir ajans için; geliştirmeye hazır, katmanları düzenli, bileşen tabanlı Figma ve PSD web tasarım dosyaları.',
			'seo'     => array( 'PSD / Figma Web Tasarımı | Geliştiriciye Hazır | Akıllı Creative', 'Yazılım ekipleri ve ajanslar için düzenli katmanlı, bileşen tabanlı, duyarlı ekran tasarımlı Figma ve PSD web tasarım dosyaları.' ),
			'intro'   => array(
				'Bazı ekipler yazılımı kendi bünyesinde geliştirir ama tasarım desteğine ihtiyaç duyar. PSD / Figma tasarım hizmetinde, web siteniz veya uygulamanız için geliştirmeye doğrudan aktarılabilecek tasarım dosyaları hazırlıyoruz.',
				'Dosyaları yalnızca güzel görünecek şekilde değil, geliştiricinin rahat çalışacağı şekilde düzenliyoruz: isimlendirilmiş katmanlar, otomatik yerleşim (auto layout), bileşenler ve varyantlar, renk ve yazı stilleri, masaüstü/tablet/mobil kırılımları. Yeni projelerde Figma’yı öneriyoruz; mevcut iş akışınız Photoshop üzerindeyse PSD olarak da teslim ediyoruz. Daha kapsamlı bir kullanıcı araştırması gerekiyorsa <a href="{home}/hizmetlerimiz/grafik-tasarim/ux-ui-tasarimi/">UX / UI tasarımı</a> hizmetimizi inceleyin.',
			),
			'scope'   => array(
				array( 'Sayfa tasarımları', 'Ana sayfa ve iç sayfaların masaüstü, tablet ve mobil tasarımları.' ),
				array( 'Bileşen kütüphanesi', 'Buton, form, kart, menü gibi tekrar eden ögelerin varyantlarıyla birlikte kütüphanesi.' ),
				array( 'Stil rehberi', 'Renk, tipografi, boşluk ve ızgara kurallarının tanımlandığı sayfa.' ),
				array( 'Etkileşim notları', 'Hover, açılır menü, animasyon ve durum (hata, yükleniyor, boş) notları.' ),
				array( 'Geliştirici teslimi', 'Dışa aktarılmış görseller, ikonlar ve ölçü bilgileriyle düzenli teslim.' ),
			),
			'for'     => array(
				array( 'Yazılım ekipleri', 'Geliştirme kapasitesi olan ama tasarımcısı olmayan ekipler.' ),
				array( 'Ajanslar', 'Tasarım tarafında dış destek almak isteyen dijital ajanslar.' ),
				array( 'Girişimler', 'Yatırımcı sunumu veya geliştirme öncesi ürününü görselleştirmek isteyenler.' ),
			),
			'needs'   => array(
				array( 'Dağınık tasarım dosyaları', 'İsimlendirilmiş, bileşen tabanlı ve bakımı kolay dosyalar hazırlıyoruz.' ),
				array( 'Mobil tasarım eksik', 'Tüm ekran kırılımlarını ayrı ayrı tasarlıyoruz.' ),
				array( 'Uygulamada tasarımdan sapma', 'Etkileşim notları ve stil rehberiyle uygulama farklarını azaltıyoruz.' ),
			),
			'deliver' => array( 'Figma (veya PSD) tasarım dosyaları', 'Masaüstü, tablet ve mobil ekranlar', 'Bileşen kütüphanesi ve varyantlar', 'Renk ve tipografi stilleri', 'Etkileşim ve durum notları', 'Dışa aktarılmış görsel ve ikon seti' ),
			'process' => array(
				array( 'Kapsam', 'Sayfa listesini, teknik kısıtları ve geliştirme altyapısını öğreniyoruz.' ),
				array( 'Stil ve bileşenler', 'Önce stil rehberini ve temel bileşenleri oluşturuyoruz.' ),
				array( 'Sayfa tasarımları', 'Sayfaları bileşenlerle kurup onayınıza sunuyoruz.' ),
				array( 'Duyarlı kırılımlar', 'Onaylanan tasarımları tablet ve mobile uyarlıyoruz.' ),
				array( 'Teslim', 'Dosyaları geliştirici notlarıyla teslim ediyoruz.' ),
			),
			'faq'     => array(
				array( 'Figma mı PSD mi tercih etmeliyim?', 'Web ve arayüz tasarımında Figma; bileşen yapısı, ortak çalışma ve geliştirici teslimi açısından daha verimlidir. Ekibiniz Photoshop ile çalışıyorsa PSD de teslim edebiliriz.' ),
				array( 'Tasarımı kodlamıyor musunuz?', 'Bu hizmette yalnızca tasarım dosyası teslim ediyoruz. Geliştirmeyi de bize bırakmak isterseniz web tasarım veya özel yazılım hizmetlerimizle birlikte planlayabiliriz.' ),
				array( 'Dosyaların sahibi kim olur?', 'Teslim edilen tasarım dosyaları size aittir; Figma dosyasını sizin hesabınıza veya ekip alanınıza aktarıyoruz.' ),
			),
		),
	),
);
