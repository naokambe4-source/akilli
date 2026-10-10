<?php
/**
 * Demo content: Web Tasarım category.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'    => 'Web Tasarım',
	'slug'     => 'web-tasarim',
	'icon'     => 'web',
	'excerpt'  => 'Markanızı doğru anlatan, hızlı açılan, mobilde rahat kullanılan ve ekibinizin kolayca yönetebildiği web siteleri tasarlıyor ve geliştiriyoruz.',
	'seo'      => array( 'Web Tasarım Hizmetleri | Antalya | Akıllı Creative', 'Antalya merkezli ekibimizle kurumsal, özel tasarım ve WordPress web siteleri geliştiriyoruz. Hızlı, mobil uyumlu, SEO altyapısı hazır siteler.' ),
	'intro'    => array(
		'Web siteniz, potansiyel müşterinizin sizinle ilk karşılaştığı yer. Bu yüzden yalnızca güzel görünen değil; ziyaretçiye ne yaptığınızı birkaç saniyede anlatan, güven veren ve onu bir sonraki adıma (arama, form, teklif, rezervasyon) yönlendiren siteler kuruyoruz.',
		'Antalya merkezli ekibimizle Türkiye’nin farklı şehirlerindeki firmalar, klinikler, hukuk büroları ve derneklerle çalışıyoruz. Tasarımı, yazılımı, içerik yerleşimini ve teknik SEO altyapısını tek ekipte ele aldığımız için siteniz parça parça değil, bütün olarak düşünülür.',
	),
	'common'   => array(
		'Tüm ekranlarda (360 px telefondan geniş monitöre) test edilmiş duyarlı tasarım',
		'Core Web Vitals hedefleriyle optimize edilmiş görseller ve kod',
		'SSL, güvenlik başlıkları ve güncel eklenti/çekirdek sürümleri',
		'Başlık hiyerarşisi, meta alanları ve site haritasıyla teknik SEO altyapısı',
		'KVKK aydınlatma metni ve çerez bilgilendirmesi için hazır sayfa yapısı',
		'Yönetim paneli eğitimi ve yazılı kullanım rehberi',
	),
	'faq'      => array(
		array( 'Web sitemi kendim güncelleyebilecek miyim?', 'Evet. Teslim ettiğimiz sitelerde sayfa, blog yazısı, görsel, menü ve iletişim bilgilerini kod bilgisi gerekmeden yönetim panelinden güncelleyebilirsiniz. Teslimde ekibinize kısa bir eğitim veriyor, yazılı bir rehber bırakıyoruz.' ),
		array( 'Bir web sitesi ne kadar sürede hazır olur?', 'Süre; sayfa sayısına, içeriklerin hazır olup olmadığına ve özel geliştirme ihtiyacına göre değişir. Teklifimizde her aşamanın takvimini yazılı olarak paylaşırız. Gecikmelerin en sık sebebi içeriklerin geç gelmesi olduğu için içerik planını projenin başında birlikte çıkarırız.' ),
		array( 'Alan adı ve hosting sizden mi alınıyor?', 'Mevcut alan adınızı ve barındırma hizmetinizi kullanabiliriz. Yoksa ihtiyacınıza uygun bir altyapı önerir, kurulumunu yaparız. Alan adı ve hosting her zaman sizin adınıza kayıtlı olur.' ),
	),
	'children' => array(
		array(
			'title'   => 'Kurumsal Web Tasarımı',
			'slug'    => 'kurumsal-web-tasarimi',
			'icon'    => 'layers',
			'label'   => 'Kurumsal Web',
			'excerpt' => 'Firmanızın uzmanlığını, hizmetlerini ve güvenilirliğini açık bir yapıyla anlatan, satış ekibinizi destekleyen kurumsal web siteleri.',
			'seo'     => array( 'Kurumsal Web Tasarımı | Akıllı Creative Antalya', 'Firmanızın hizmetlerini net anlatan, teklif ve iletişim talebi toplayan, kolay yönetilen kurumsal web siteleri. Antalya merkezli, Türkiye geneli hizmet.' ),
			'intro'   => array(
				'Kurumsal bir web sitesinin işi, ziyaretçinin “Bu firma işimi çözebilir mi?” sorusuna hızlıca evet dedirtmektir. Hizmetlerinizi, çalışma şeklinizi, ekibinizi ve iletişim kanallarınızı mantıklı bir sırayla sunan; her sayfada ziyaretçiyi bir sonraki adıma taşıyan bir yapı kuruyoruz.',
				'Sitenizi yalnızca bugünkü ihtiyaca göre değil, yeni hizmet, şube veya dil eklediğinizde de dağılmayacak şekilde planlıyoruz. Arama motorlarında görünürlük için gereken teknik temeli de en baştan yerleştiriyoruz; içerik ve <a href="{home}/hizmetlerimiz/dijital-buyume/seo/">SEO çalışmasıyla</a> bu temel zamanla değer kazanır.',
			),
			'scope'   => array(
				array( 'Bilgi mimarisi ve site haritası', 'Hangi sayfaların olacağını, menüde nasıl gruplanacağını ve ziyaretçinin hangi yoldan teklif formuna ulaşacağını planlıyoruz.' ),
				array( 'Markaya özel arayüz tasarımı', 'Kurumsal renkleriniz, yazı tipleriniz ve görsel dilinizle uyumlu; hazır şablon görünümünden uzak bir tasarım hazırlıyoruz.' ),
				array( 'Hizmet ve ürün sayfaları', 'Her hizmet için kapsam, süreç ve sık sorulan sorular içeren, arama motorlarının da anlayabileceği ayrı sayfalar kuruyoruz.' ),
				array( 'Teklif ve iletişim formları', 'Gelen talepleri panelde saklayan, ilgili kişiye e-postayla ileten, spam korumalı formlar ekliyoruz.' ),
				array( 'Çok dilli yapı (isteğe bağlı)', 'Yurt dışı müşterileriniz varsa İngilizce veya başka dillerde içerik yönetilebilecek bir altyapı kuruyoruz.' ),
				array( 'Performans ve güvenlik', 'Görsel optimizasyonu, önbellekleme ve güncel güvenlik ayarlarıyla hızlı ve güvenli bir site teslim ediyoruz.' ),
			),
			'for'     => array(
				array( 'Hizmet firmaları', 'Mühendislik, danışmanlık, inşaat, lojistik gibi teklif usulü çalışan firmalar.' ),
				array( 'Üretici ve tedarikçiler', 'Ürün kataloğunu ve üretim kabiliyetini bayilere ve kurumsal alıcılara göstermek isteyen işletmeler.' ),
				array( 'Yeniden yapılanan markalar', 'Mevcut sitesi eskimiş, mobilde zor kullanılan veya güncellenemeyen firmalar.' ),
			),
			'needs'   => array(
				array( 'Ziyaretçi ne yaptığınızı anlamıyor', 'Ana sayfa ve hizmet sayfalarındaki mesajı sadeleştirip, öne çıkması gerekeni öne çıkarıyoruz.' ),
				array( 'Site talep getirmiyor', 'Her sayfaya uygun çağrı alanları, görünür iletişim bağlantıları ve kısa formlar yerleştiriyoruz.' ),
				array( 'İçerik güncellemek zor', 'Ekibinizin rahatça kullanabileceği, düzenli bir yönetim paneli kuruyoruz.' ),
			),
			'deliver' => array( 'Site haritası ve sayfa içerik planı', 'Masaüstü ve mobil arayüz tasarımları', 'Yönetim paneliyle çalışan, kurulmuş ve yayına alınmış web sitesi', 'Hizmet, hakkımızda, iletişim ve teklif sayfaları', 'Spam korumalı ve kayıt tutan iletişim formları', 'Temel teknik SEO ayarları ve site haritası', 'KVKK ve çerez bilgilendirme sayfa şablonları', 'Panel eğitimi ve yazılı kullanım rehberi' ),
			'process' => array(
				array( 'Keşif görüşmesi', 'Hedeflerinizi, müşteri profilinizi, rakiplerinizi ve mevcut sitenizin eksiklerini konuşuyoruz.' ),
				array( 'Yapı ve içerik planı', 'Sayfa listesini, menü yapısını ve her sayfada yer alacak içerikleri belirliyoruz.' ),
				array( 'Tasarım', 'Ana sayfa ve örnek iç sayfa tasarımlarını sunuyor, geri bildirimlerinize göre netleştiriyoruz.' ),
				array( 'Geliştirme ve içerik girişi', 'Siteyi kodluyor, içerikleri yerleştiriyor, formları ve SEO ayarlarını yapıyoruz.' ),
				array( 'Test, yayın ve eğitim', 'Farklı cihazlarda test edip siteyi yayına alıyor, ekibinize panel eğitimi veriyoruz.' ),
			),
			'faq'     => array(
				array( 'Kurumsal sitemizin içeriklerini siz mi yazıyorsunuz?', 'İsterseniz evet. Sizden aldığımız bilgilerle hizmet sayfalarının metinlerini düzenleyebilir veya sıfırdan yazabiliriz. Teknik bilgilerin doğruluğunu sizinle birlikte kontrol ederiz.' ),
				array( 'Mevcut sitemizdeki içerikler ve Google sıralamaları ne olur?', 'Yeni siteye geçerken eski adresleri yenileriyle eşleştiren 301 yönlendirmeleri kurarız. Böylece ziyaretçiler ve arama motorları eski bağlantılardan doğru sayfaya ulaşır. Sıralamaların korunacağını garanti edemeyiz; ancak geçişten kaynaklanan kayıp riskini en aza indirecek adımları uygularız.' ),
				array( 'Teslimden sonra destek veriyor musunuz?', 'Evet. Yayın sonrası belirli bir süre ücretsiz hata düzeltme desteği veriyoruz; sonrasında güncelleme, yedekleme ve küçük geliştirmeler için bakım paketi sunuyoruz.' ),
				array( 'Kurumsal sitede blog olmalı mı?', 'Arama motorlarında daha fazla soruya cevap vermek ve uzmanlığınızı göstermek istiyorsanız faydalıdır. Düzenli içerik üretemeyecekseniz blog yerine güncel tutulan hizmet sayfaları ve sık sorulan sorular daha doğru bir başlangıçtır.' ),
			),
		),
		array(
			'title'   => 'Özel Web Sitesi Tasarımı',
			'slug'    => 'ozel-web-sitesi-tasarimi',
			'icon'    => 'spark',
			'label'   => 'Özel Tasarım Web',
			'excerpt' => 'Şablon kullanmadan, markanıza ve hedefinize göre sıfırdan tasarlanan; etkileşimli, akılda kalan web deneyimleri.',
			'seo'     => array( 'Özel Web Sitesi Tasarımı | Şablonsuz Tasarım | Akıllı Creative', 'Hazır şablon yerine markanıza özel kurgulanan, animasyon ve etkileşimlerle güçlendirilmiş web siteleri. Lansman, kampanya ve premium markalar için.' ),
			'intro'   => array(
				'Bazı markalar için “düzgün çalışan bir site” yetmez; sitenin kendisi markanın ne kadar özenli olduğunu göstermelidir. Özel web sitesi tasarımında sayfa düzenini, tipografiyi, görsel anlatımı ve etkileşimleri hiçbir şablona bağlı kalmadan, yalnızca sizin hikâyeniz için kurguluyoruz.',
				'Hareketli tipografi, kaydırmayla ilerleyen anlatım, 3B/WebGL ögeleri ya da etkileşimli ürün sunumları gibi teknikleri yalnızca mesajı güçlendirdiği yerde kullanıyoruz. Hız, erişilebilirlik ve mobil kullanım her zaman tasarımın parçası; efektler kapalıyken bile site eksiksiz çalışır.',
			),
			'scope'   => array(
				array( 'Kreatif konsept', 'Markanızın kişiliğini web’e taşıyacak görsel fikri, renk ve tipografi sistemini ve hareket dilini belirliyoruz.' ),
				array( 'Etkileşim tasarımı', 'Geçişleri, kaydırma animasyonlarını ve hover etkileşimlerini prototip üzerinde deneyerek tasarlıyoruz.' ),
				array( 'Özel kodlanmış ön yüz', 'Tasarımı birebir uygulayan, gereksiz kütüphane yüklemeyen, performans bütçesine uyan ön yüz kodu yazıyoruz.' ),
				array( 'Yönetilebilir içerik', 'Özel tasarımın içeriklerini de panelden düzenlenebilir bloklar halinde kuruyoruz.' ),
				array( 'Mobil için yeniden düşünülmüş deneyim', 'Masaüstündeki ağır efektleri telefona taşımak yerine dokunmatik kullanıma uygun alternatifler tasarlıyoruz.' ),
			),
			'for'     => array(
				array( 'Premium markalar', 'Mimarlık, tasarım, gayrimenkul, otel ve lüks ürün markaları.' ),
				array( 'Lansman ve kampanyalar', 'Yeni ürün, proje veya etkinliği dikkat çekici biçimde duyurmak isteyenler.' ),
				array( 'Kreatif sektörler', 'Portföyünü güçlü bir deneyimle sunmak isteyen ajans, stüdyo ve sanatçılar.' ),
			),
			'needs'   => array(
				array( 'Rakiplerden ayrışamamak', 'Şablon görünümünden uzak, markaya özgü bir görsel dil oluşturuyoruz.' ),
				array( 'Ürünün değerini anlatamamak', 'Kaydırmayla ilerleyen anlatım ve etkileşimli görsellerle karmaşık bir ürünü adım adım gösteriyoruz.' ),
				array( 'Etkileyici ama yavaş siteler', 'Efektleri performans bütçesiyle planlıyor, ağır içerikleri yalnızca gerektiğinde yüklüyoruz.' ),
			),
			'deliver' => array( 'Kreatif konsept sunumu ve moodboard', 'Tasarım sistemi (renk, tipografi, bileşenler)', 'Etkileşimli prototip', 'Özel kodlanmış, yönetim panelli web sitesi', 'Hareket azaltma tercihine uyumlu animasyonlar', 'Performans ve erişilebilirlik test raporu', 'Panel eğitimi' ),
			'process' => array(
				array( 'Marka ve hedef analizi', 'Markanızın neyi hissettirmesi gerektiğini ve ziyaretçiden ne beklediğimizi netleştiriyoruz.' ),
				array( 'Konsept ve moodboard', 'İki farklı yaratıcı yön sunuyor, birini birlikte seçiyoruz.' ),
				array( 'Prototip', 'Kritik sayfaları ve etkileşimleri tıklanabilir prototip olarak test ediyoruz.' ),
				array( 'Geliştirme', 'Tasarımı performans bütçesi içinde kodluyor, içerik yönetimini kuruyoruz.' ),
				array( 'İnce ayar ve yayın', 'Cihaz testleri, erişilebilirlik kontrolleri ve hız ölçümlerinden sonra yayına alıyoruz.' ),
			),
			'faq'     => array(
				array( 'Özel tasarım site, kurumsal siteden ne kadar farklı?', 'Kurumsal sitede kanıtlanmış düzenleri markanıza uyarlarız. Özel tasarımda ise sayfa kurgusu ve etkileşimler sıfırdan tasarlanır; konsept, prototip ve özel geliştirme aşamaları eklendiği için süre ve bütçe daha yüksektir.' ),
				array( 'Animasyonlar siteyi yavaşlatmaz mı?', 'Yanlış uygulanırsa yavaşlatır. Biz animasyonları tarayıcının verimli çalıştığı yöntemlerle yazıyor, ağır görselleri gerektiğinde yüklüyor ve her sayfa için hız ölçümü yapıyoruz.' ),
				array( 'Engelli kullanıcılar ve hareket hassasiyeti olanlar için ne yapıyorsunuz?', 'Klavye ile gezinme, yeterli kontrast ve ekran okuyucu uyumluluğu sağlıyoruz. İşletim sisteminde “hareketi azalt” seçeneği açık olan ziyaretçiler için animasyonlar otomatik olarak sadeleşir.' ),
			),
		),
		array(
			'title'   => 'WordPress Web Sitesi',
			'slug'    => 'wordpress-web-sitesi',
			'icon'    => 'wordpress',
			'label'   => 'WordPress Site',
			'excerpt' => 'Dünyanın en yaygın içerik yönetim sistemiyle; hızlı, güvenli, eklenti yığınına dönüşmemiş ve kolay yönetilen WordPress siteleri.',
			'seo'     => array( 'WordPress Web Sitesi Yaptırma | Özel Tema | Akıllı Creative', 'Hazır tema kalabalığı yerine size özel, hızlı ve güvenli WordPress siteleri. Gutenberg ile kolay içerik yönetimi, bakım ve güncelleme desteği.' ),
			'intro'   => array(
				'WordPress; içeriklerini sık güncelleyen, blog yazan, birden fazla kişinin panelde çalıştığı işletmeler için güçlü bir seçimdir. Ancak birçok WordPress sitesi, onlarca eklenti ve ağır hazır temalarla yavaş ve güvenlik açıklarına açık hale gelir.',
				'Biz WordPress sitelerini size özel, hafif bir temayla ve yalnızca gerçekten gereken eklentilerle kuruyoruz. İçerikleri Gutenberg blok editörüyle düzenlenebilir hale getiriyor, ücretli sayfa oluşturuculara zorunlu bağımlılık yaratmıyoruz. Online satış planınız varsa <a href="{home}/hizmetlerimiz/e-ticaret-yazilimi/wordpress-e-ticaret/">WordPress e-ticaret</a> altyapısına geçişi de en baştan düşünerek tasarlıyoruz.',
			),
			'scope'   => array(
				array( 'Özel WordPress teması', 'Tasarımınıza göre kodlanmış, gereksiz özellik taşımayan bir tema geliştiriyoruz.' ),
				array( 'Gutenberg blokları', 'Sık kullandığınız bölümleri (hizmet kartları, SSS, referanslar) sürükle-bırak eklenebilen bloklar haline getiriyoruz.' ),
				array( 'Kontrollü eklenti seçimi', 'Her eklentiyi güvenlik, bakım geçmişi ve performans etkisine göre seçiyor; işi kodla daha temiz çözebiliyorsak eklenti kullanmıyoruz.' ),
				array( 'Taşıma ve yenileme', 'Eski WordPress sitenizdeki içerikleri yeni yapıya aktarıyor, eski bağlantıları yönlendiriyoruz.' ),
				array( 'Bakım ve yedekleme', 'Çekirdek ve eklenti güncellemeleri, düzenli yedekler ve güvenlik izlemesi için bakım planı sunuyoruz.' ),
			),
			'for'     => array(
				array( 'İçerik üreten işletmeler', 'Blog, haber, duyuru veya kampanya sayfalarını kendi ekibiyle yayınlayanlar.' ),
				array( 'Yavaşlamış WordPress siteleri', 'Ağır hazır tema ve eklenti yükü yüzünden yavaşlamış, güncellenmekten korkulan siteler.' ),
				array( 'Büyümeyi planlayanlar', 'İleride e-ticaret, üyelik veya çoklu dil eklemek isteyen işletmeler.' ),
			),
			'needs'   => array(
				array( 'Site çok yavaş', 'Gereksiz eklentileri kaldırıyor, görselleri optimize ediyor, hafif bir temayla yeniden kuruyoruz.' ),
				array( 'Güncelleme yapınca bir şey bozuluyor', 'Kontrollü eklenti seti ve test ortamıyla güncellemeleri güvenli hale getiriyoruz.' ),
				array( 'Panel karmaşık', 'Ekibinizin kullanmadığı ayarları gizleyip yalnızca ihtiyacınız olan alanları bırakıyoruz.' ),
			),
			'deliver' => array( 'Size özel WordPress teması', 'Sayfa ve bölüm şablonları (Gutenberg blokları)', 'Kurulu ve yapılandırılmış WordPress sitesi', 'Güvenlik ve performans ayarları', 'İçerik taşıma ve 301 yönlendirmeleri (yenilemelerde)', 'Yedekleme yapılandırması', 'Panel eğitimi ve kullanım rehberi' ),
			'process' => array(
				array( 'İhtiyaç ve mevcut durum analizi', 'Varsa mevcut sitenizin hızını, eklentilerini ve içerik yapısını inceliyoruz.' ),
				array( 'Tasarım', 'Sayfa tasarımlarını hazırlıyor ve blok yapısını planlıyoruz.' ),
				array( 'Tema ve blok geliştirme', 'Özel temayı ve Gutenberg bloklarını kodluyoruz.' ),
				array( 'İçerik aktarımı', 'İçerikleri yerleştiriyor veya eski siteden taşıyoruz.' ),
				array( 'Test, yayın ve bakım', 'Testlerden sonra yayına alıyor, isterseniz bakım planına geçiyoruz.' ),
			),
			'faq'     => array(
				array( 'Hazır tema satın alıp özelleştirmek daha ucuz değil mi?', 'Başlangıçta daha ucuz olabilir. Ancak hazır temalar birçok kullanılmayan özellik taşıdığından site yavaşlar ve güncellemelerde uyumsuzluk riski artar. Özel tema, uzun vadede daha düşük bakım maliyeti ve daha iyi performans sağlar.' ),
				array( 'Elementor gibi bir sayfa oluşturucu kullanıyor musunuz?', 'Zorunlu olarak kullanmıyoruz. İçerikleri WordPress’in yerleşik Gutenberg editörü ve size özel bloklarla düzenlenebilir hale getiriyoruz; böylece ek lisans ücreti ve bağımlılık oluşmaz.' ),
				array( 'WordPress güvenli mi?', 'Güncel tutulan, güvenilir eklentilerle kurulan ve düzenli yedeklenen bir WordPress sitesi güvenlidir. Sorunların büyük kısmı güncellenmeyen eklenti ve temalardan kaynaklanır; bakım planımız bu riski azaltmak için vardır.' ),
			),
		),
		array(
			'title'   => 'Avukat Web Tasarımı',
			'slug'    => 'avukat-web-tasarimi',
			'icon'    => 'scale',
			'label'   => 'Avukat Web Sitesi',
			'excerpt' => 'Avukatlık meslek kurallarına ve reklam yasağına uygun; çalışma alanlarınızı ölçülü ve güven veren bir dille anlatan hukuk bürosu web siteleri.',
			'seo'     => array( 'Avukat Web Tasarımı | Hukuk Bürosu Web Sitesi | Akıllı Creative', 'Reklam yasağına uygun, bilgilendirici ve güven veren hukuk bürosu web siteleri. Çalışma alanları, makaleler ve KVKK uyumlu iletişim formları.' ),
			'intro'   => array(
				'Avukatlar için web sitesi, bir reklam aracı değil; büroyu ve çalışma alanlarını tanıtan bir bilgilendirme kanalıdır. Avukatlık Kanunu ve Türkiye Barolar Birliği’nin reklam yasağına ilişkin düzenlemeleri; abartılı ifadeleri, başarı vaadini, müvekkil yorumlarını ve iş toplamaya yönelik dili sınırlar. Tasarımı ve metinleri bu çerçeveyi gözeterek kuruyoruz.',
				'Ziyaretçi; büronun hangi alanlarda çalıştığını, avukatların mesleki geçmişini ve büroya nasıl ulaşacağını sade bir yapıda bulur. Hukuki makaleler ve güncel mevzuat yazıları için düzenli bir blog alanı ekleyerek uzmanlığınızı bilgilendirici içerikle göstermenizi sağlıyoruz. Metinlerin son kontrolünün sizde olmasını öneriyoruz; meslek kuralları konusunda sorumluluk büroya aittir.',
			),
			'scope'   => array(
				array( 'Çalışma alanı sayfaları', 'Ceza, iş, aile, ticaret, gayrimenkul gibi her alan için bilgilendirici ve ölçülü dille yazılmış sayfalar.' ),
				array( 'Avukat profilleri', 'Baro sicil bilgisi, eğitim, yayınlar ve uzmanlık alanlarını içeren sade profil sayfaları.' ),
				array( 'Makale ve mevzuat blogu', 'Kategori ve etiketlerle düzenlenen, yazar bilgili hukuki makale alanı.' ),
				array( 'KVKK uyumlu iletişim', 'Aydınlatma metni onaylı, gizlilik hassasiyetine uygun iletişim formu ve randevu talebi.' ),
				array( 'Çok dilli yapı', 'Yabancı müvekkillerle çalışan bürolar için İngilizce veya diğer dillerde içerik desteği.' ),
			),
			'for'     => array(
				array( 'Bireysel avukatlar', 'Kendi bürosunu açan veya dijitalde görünür olmak isteyen avukatlar.' ),
				array( 'Avukatlık ortaklıkları', 'Birden fazla avukat ve çalışma alanı bulunan hukuk büroları.' ),
				array( 'Danışmanlık odaklı bürolar', 'Şirketlere sürekli hukuki danışmanlık veren, kurumsal müvekkil kitlesine hitap eden bürolar.' ),
			),
			'needs'   => array(
				array( 'Meslek kurallarına uygunluk kaygısı', 'Abartılı ve reklam niteliği taşıyabilecek ifadelerden kaçınan, bilgilendirici bir içerik dili kuruyoruz.' ),
				array( 'Güven ve ciddiyet', 'Sade tipografi, dengeli boşluklar ve ölçülü renklerle kurumsal bir görünüm tasarlıyoruz.' ),
				array( 'Uzmanlığı gösterememek', 'Makale alanı ve çalışma alanı sayfalarıyla uzmanlığı bilgi paylaşımı üzerinden gösteriyoruz.' ),
			),
			'deliver' => array( 'Büro tanıtım ve çalışma alanı sayfaları', 'Avukat profil sayfaları', 'Makale/blog altyapısı ve kategori yapısı', 'KVKK aydınlatma metni onaylı iletişim formu', 'Harita, ulaşım ve çalışma saatleri bilgisi', 'Mobil uyumlu, hızlı açılan arayüz', 'Panel eğitimi' ),
			'process' => array(
				array( 'Tanışma ve kapsam', 'Büronun çalışma alanlarını, hedef müvekkil profilini ve mevcut materyallerini konuşuyoruz.' ),
				array( 'İçerik çerçevesi', 'Meslek kurallarını gözeterek hangi bilgilerin nasıl sunulacağını birlikte belirliyoruz.' ),
				array( 'Tasarım', 'Büronun kurumsal kimliğine uygun, sade ve güven veren arayüzü hazırlıyoruz.' ),
				array( 'Geliştirme ve içerik', 'Siteyi kuruyor, metinleri yerleştiriyor, son kontrolünüze sunuyoruz.' ),
				array( 'Yayın ve eğitim', 'Siteyi yayına alıyor, makale yayınlamayı öğretiyoruz.' ),
			),
			'faq'     => array(
				array( 'Avukat web sitesinde neler paylaşılabilir?', 'Genel olarak büronun adı, iletişim bilgileri, avukatların mesleki bilgileri, çalışma alanları ve bilgilendirici makaleler paylaşılabilir. Başarı oranı, müvekkil yorumu, ücret karşılaştırması ve iş toplamaya yönelik ifadeler reklam yasağı kapsamında sorun oluşturabilir. Güncel kurallar için bağlı olduğunuz baronun düzenlemelerini esas almanızı öneririz.' ),
				array( 'Google reklamı verebilir miyiz?', 'Avukatlık mesleğinde reklam yasağı bulunduğu için ücretli reklam çalışmalarını önermiyoruz. Bunun yerine bilgilendirici içerik ve teknik SEO ile doğal görünürlüğe odaklanıyoruz.' ),
				array( 'Makaleleri kim yazıyor?', 'Hukuki içeriklerin doğruluğu ve sorumluluğu büroya ait olduğu için makaleleri sizin yazmanızı veya onaylamanızı öneriyoruz. Biz yayınlama, düzenleme ve sayfa yapısı konusunda destek oluyoruz.' ),
			),
		),
		array(
			'title'   => 'Diş Kliniği Web Tasarımı',
			'slug'    => 'dis-klinigi-web-tasarimi',
			'icon'    => 'tooth',
			'label'   => 'Diş Kliniği Web',
			'excerpt' => 'Tedavileri anlaşılır biçimde anlatan, randevu talebini kolaylaştıran, sağlık tanıtım mevzuatını gözeten diş kliniği ve poliklinik web siteleri.',
			'seo'     => array( 'Diş Kliniği Web Tasarımı | Randevu Odaklı | Akıllı Creative', 'Tedavi sayfaları, hekim profilleri, randevu talebi ve çok dilli yapı içeren diş kliniği web siteleri. Antalya ve Türkiye geneli.' ),
			'intro'   => array(
				'Diş kliniğine gelen hastaların çoğu önce internette araştırır: hangi tedaviler yapılıyor, hekimler kim, klinik nerede, randevu nasıl alınır? Diş kliniği web sitelerinde bu soruları sakin, anlaşılır ve güven veren bir dille cevaplayan; randevu talebini birkaç dokunuşla mümkün kılan bir yapı kuruyoruz.',
				'Sağlık hizmetlerinin tanıtımı Türkiye’de ilgili mevzuatla sınırlandırılmıştır; yanıltıcı ifadeler, garanti vaatleri ve bazı görsel/yorum kullanımları sorun oluşturabilir. İçerik yapısını bu hassasiyeti gözeterek kuruyor, metinlerin son onayını kliniğin sorumlu hekimine bırakıyoruz. Yurt dışından hasta kabul ediyorsanız <a href="{home}/hizmetlerimiz/dijital-buyume/saglik-turizmi-dijital-pazarlama/">sağlık turizmi dijital pazarlama</a> hizmetimizle çok dilli yapıyı birlikte planlayabiliriz.',
			),
			'scope'   => array(
				array( 'Tedavi sayfaları', 'İmplant, ortodonti, estetik diş hekimliği, kanal tedavisi gibi her tedavi için süreç ve sık sorular içeren bilgilendirici sayfalar.' ),
				array( 'Hekim ve ekip profilleri', 'Hekimlerin eğitim ve uzmanlık bilgilerini içeren sade profil sayfaları.' ),
				array( 'Randevu talebi', 'Telefon, WhatsApp ve form üzerinden kolay randevu talebi; talepler panelde kayıt altında.' ),
				array( 'Klinik tanıtımı', 'Klinik ortamını, cihazları ve hijyen süreçlerini gösteren fotoğraf ve video alanları.' ),
				array( 'Çok dilli içerik', 'Yabancı hastalar için İngilizce, Almanca, Rusça gibi dillerde yönetilebilir içerik yapısı.' ),
			),
			'for'     => array(
				array( 'Muayenehaneler', 'Tek hekimli veya küçük ekipli muayenehaneler.' ),
				array( 'Diş klinikleri ve poliklinikler', 'Birden fazla hekim ve tedavi alanı bulunan sağlık kuruluşları.' ),
				array( 'Sağlık turizmi yapan klinikler', 'Yurt dışından hasta kabul eden, çok dilli iletişim kuran klinikler.' ),
			),
			'needs'   => array(
				array( 'Hastalar tedavileri anlamıyor', 'Teknik terimleri sadeleştiren, süreci adım adım anlatan tedavi sayfaları hazırlıyoruz.' ),
				array( 'Randevu süreci zahmetli', 'Mobilde sabit duran arama, WhatsApp ve randevu düğmeleriyle iletişimi kolaylaştırıyoruz.' ),
				array( 'Mevzuata uygunluk endişesi', 'Abartılı ve garanti içeren ifadelerden kaçınan, bilgilendirici bir içerik çerçevesi öneriyoruz.' ),
			),
			'deliver' => array( 'Tedavi sayfaları için içerik şablonu', 'Hekim profil sayfaları', 'Randevu talep formu ve panelde talep takibi', 'Telefon ve WhatsApp hızlı iletişim düğmeleri', 'Klinik galeri ve video alanları', 'Çok dilli yapı (isteğe bağlı)', 'Yerel arama için temel SEO ayarları', 'Panel eğitimi' ),
			'process' => array(
				array( 'Klinik ziyareti veya görüşme', 'Tedavi alanlarınızı, hasta profilinizi ve randevu akışınızı öğreniyoruz.' ),
				array( 'İçerik planı', 'Tedavi sayfalarının yapısını ve mevzuat açısından dikkat edilecek noktaları belirliyoruz.' ),
				array( 'Tasarım', 'Ferah, temiz ve sakinleştirici bir arayüz tasarlıyoruz.' ),
				array( 'Geliştirme ve içerik girişi', 'Siteyi kuruyor, içerikleri yerleştiriyor, hekim onayına sunuyoruz.' ),
				array( 'Yayın ve eğitim', 'Siteyi yayına alıyor, randevu taleplerini nasıl takip edeceğinizi gösteriyoruz.' ),
			),
			'faq'     => array(
				array( 'Önce/sonra fotoğrafları kullanabilir miyiz?', 'Sağlık tanıtımına ilişkin mevzuat, hasta görselleri ve tedavi sonuçlarının sunumu konusunda sınırlamalar içerir. Bu tür içerikleri kullanmadan önce güncel mevzuatı ve meslek odanızın görüşünü kontrol etmenizi öneririz. Biz alternatif olarak süreç anlatımı ve klinik tanıtımına odaklanan içerik yapıları öneriyoruz.' ),
				array( 'Online randevu sistemi kurabilir misiniz?', 'Randevu talep formu standart olarak gelir. Kliniğinizin kullandığı bir randevu/hasta yönetim yazılımı varsa, sağladığı entegrasyon imkânlarına göre bağlantı kurabilir veya ihtiyaca özel bir modül geliştirebiliriz.' ),
				array( 'Fiyat listesi yayınlamalı mıyız?', 'Bu karar kliniğinize ve tabi olduğunuz düzenlemelere bağlıdır. Fiyatların sık değiştiği durumlarda “muayene sonrası bilgilendirme” yaklaşımı ve net bir iletişim çağrısı genellikle daha sağlıklıdır.' ),
			),
		),
		array(
			'title'   => 'Dernek Web Sitesi Tasarımı',
			'slug'    => 'dernek-web-sitesi-tasarimi',
			'icon'    => 'heart',
			'label'   => 'Dernek Web Sitesi',
			'excerpt' => 'Faaliyetleri, duyuruları ve şeffaflık bilgilerini düzenli sunan; bağış, üyelik ve gönüllü başvurusunu kolaylaştıran dernek ve vakıf siteleri.',
			'seo'     => array( 'Dernek Web Sitesi Tasarımı | Bağış ve Üyelik | Akıllı Creative', 'Faaliyet, duyuru, bağış, üyelik ve gönüllü başvurusu modülleri olan, gönüllü ekiplerin kolayca yönetebildiği dernek ve vakıf web siteleri.' ),
			'intro'   => array(
				'Bir derneğin web sitesi hem üyeleriyle hem de destekçileriyle kurduğu güven ilişkisinin merkezidir. Ziyaretçi derneğin amacını, yaptığı çalışmaları, yönetim kurulunu ve nasıl destek olabileceğini kolayca bulabilmelidir.',
				'Dernek sitelerini, çoğu zaman gönüllülerden oluşan ekiplerin teknik bilgi olmadan güncelleyebileceği şekilde kuruyoruz. Etkinlik ve duyuru yayınlamak, faaliyet raporu yüklemek veya bağış kampanyası açmak birkaç dakikalık iş haline gelir. Online bağış almak istiyorsanız <a href="{home}/hizmetlerimiz/e-ticaret-yazilimi/sanal-pos-entegrasyonu/">sanal POS entegrasyonuyla</a> güvenli ödeme altyapısını kuruyoruz.',
			),
			'scope'   => array(
				array( 'Kurumsal tanıtım', 'Tüzük, misyon, yönetim kurulu ve iletişim bilgileri için düzenli sayfa yapısı.' ),
				array( 'Faaliyet ve duyuru yönetimi', 'Etkinlik, haber ve duyuruları fotoğraf galerileriyle yayınlayabileceğiniz içerik alanları.' ),
				array( 'Bağış altyapısı', 'Banka hesap bilgileri ve isteğe bağlı sanal POS ile güvenli online bağış sayfası.' ),
				array( 'Üyelik ve gönüllü başvurusu', 'Başvuruları panelde toplayan, KVKK onaylı formlar.' ),
				array( 'Şeffaflık alanı', 'Faaliyet raporları, mali tablolar ve belgeler için düzenli bir doküman arşivi.' ),
			),
			'for'     => array(
				array( 'Dernekler', 'Meslek, hemşehri, spor, eğitim ve sosyal yardım dernekleri.' ),
				array( 'Vakıflar', 'Burs, bağış ve proje yürüten vakıflar.' ),
				array( 'Kooperatif ve birlikler', 'Üyeleriyle düzenli iletişim kurması gereken kuruluşlar.' ),
			),
			'needs'   => array(
				array( 'Güncellenemeyen site', 'Gönüllülerin rahat kullanabileceği, sade bir yönetim paneli kuruyoruz.' ),
				array( 'Bağışçı güveni', 'Faaliyetleri ve belgeleri düzenli sunan bir şeffaflık alanı tasarlıyoruz.' ),
				array( 'Dağınık başvurular', 'Üyelik ve gönüllü başvurularını tek panelde topluyoruz.' ),
			),
			'deliver' => array( 'Kurumsal tanıtım sayfaları', 'Etkinlik, haber ve duyuru modülü', 'Bağış sayfası (banka bilgisi ve isteğe bağlı sanal POS)', 'Üyelik ve gönüllü başvuru formları', 'Belge ve faaliyet raporu arşivi', 'Sosyal medya bağlantıları ve paylaşım ayarları', 'Gönüllü ekibe panel eğitimi' ),
			'process' => array(
				array( 'Tanışma', 'Derneğin amacını, hedef kitlesini ve iletişim ihtiyaçlarını konuşuyoruz.' ),
				array( 'Modül planı', 'Bağış, üyelik, etkinlik gibi ihtiyaç duyulan modülleri belirliyoruz.' ),
				array( 'Tasarım', 'Derneğin kimliğine uygun, sıcak ve erişilebilir bir arayüz tasarlıyoruz.' ),
				array( 'Kurulum ve içerik', 'Siteyi kuruyor, mevcut içerik ve belgeleri yerleştiriyoruz.' ),
				array( 'Eğitim ve yayın', 'Gönüllü ekibinizi eğitip siteyi yayına alıyoruz.' ),
			),
			'faq'     => array(
				array( 'Online bağış almak için ne gerekiyor?', 'Derneğiniz adına bir banka veya ödeme kuruluşuyla sanal POS sözleşmesi yapmanız gerekir. Sözleşme sonrası verilen API bilgileriyle bağış sayfasını entegre ediyoruz. Bağış toplama faaliyetlerine ilişkin yasal yükümlülükleri derneğinizin danışmanıyla kontrol etmenizi öneririz.' ),
				array( 'Birden fazla kişi siteyi yönetebilir mi?', 'Evet. Farklı yetki seviyelerinde kullanıcılar tanımlayabiliriz; örneğin bir gönüllü yalnızca duyuru yayınlarken yönetici tüm ayarları değiştirebilir.' ),
				array( 'Üye bilgilerini sitede tutmak güvenli mi?', 'Başvuru formlarından gelen bilgiler yalnızca yetkili kullanıcıların erişebildiği yönetim panelinde saklanır. KVKK kapsamında aydınlatma metni, açık rıza ve saklama süreleri konusunda derneğinizin politikasını uygulamanızı öneririz.' ),
			),
		),
	),
);
