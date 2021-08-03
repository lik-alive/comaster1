<script type="text/javascript">
	$(document).ready(function() {
		//Hide/Show Updates
		$('.collapseheader').click(function() {
			var text = $(this).html().substring(1);
			if ($(this).parent().parent().find('.collapse').hasClass('in')) $(this).html('&plus;' + text);
			else $(this).html('&minus;' + text);
		});

		//Auto close last update
		{
			var today = new Date();
			var updateElapsed = new Date(2018, 01 - 1, 22);
			if (today > updateElapsed) $('#updates').find('.collapseheader:first').trigger('click');
		}
	});
</script>

<div>
	<div class='infnews'>
		<div class='inftitle'>Обновления (последнее: 19.01.2018)</div>
		<div class='inftitledelim'></div>
		<div id='updates' class='panel-collapse collapse in'>
			<div>
				<div><a class='collapseheader' data-toggle='collapse' href='#upd1901'>&minus;Обновление от 19.01.2018</a></div>
				<div id='upd1901' class='panel-collapse collapse in'>
					<ul>
						<div><b>1. Восстание машин не состоялось. Сайт жив.</b></div>
						<div><b>2. Обновлена переписка рецензенты-авторы: теперь через pdf-формы.</b></div>
					</ul>
				</div>
			</div>

			<div>
				<div><a class='collapseheader' data-toggle='collapse' href='#archive'>&plus;Архив</a></div>
				<div id='archive' class='panel-collapse collapse'>
					<ul>
						<div>
							<div><a class='collapseheader' data-toggle='collapse' href='#upd2211'>&plus;Обновление от 22.11.2017</a></div>
							<div id='upd2211' class='panel-collapse collapse'>
								<ul>
									<div><b>1. Главная</b></div>
									<ul>
										<div><b>1.1. Добавлена информация о "подвисших" статьях</b></div>
									</ul>
									<div><b>2. Портфель</b></div>
									<ul>
										<div><b>2.1. Отображение как портфеля, так и формируемых номеров</b></div>
									</ul>
									<ul>
										<div><b>2.2. Возможность упорядочить статьи в номере</b></div>
									</ul>
									<div><b>3. Рецензенты</b></div>
									<ul>
										<div>3.1. Добавлен пункт "Должность и место работы"</div>
									</ul>
									<ul>
										<div>3.2. В детальной информации о рецензентах теперь отображаются отдельно активные рецензии и отдельно отработанные</div>
									</ul>
									<div>4. Много багов полегло...</div>
								</ul>
							</div>
							<div><a class='collapseheader' data-toggle='collapse' href='#upd0911'>&plus;Обновление от 09.11.2017</a></div>
							<div id='upd0911' class='panel-collapse collapse'>
								<ul>
									<div><b>1. Расширен список пользователей сайта</b></div>
									<div><b>2. При добавлении рецензента отображается его рейтинг</b></div>
									<div><b>3. На все письма добавлена отложенная отправка - 2 часа (можно успеть отменить)</b></div>
									<div><b>4. Обновлённый интерфейс</b></div>
									<div>5. Исправлено отображение срока статьи в работе</div>
									<div>...мелкие исправления</div>
								</ul>
							</div>
							<div><a class='collapseheader' data-toggle='collapse' href='#upd0711'>&plus;Обновление от 07.11.2017</a></div>
							<div id='upd0711' class='panel-collapse collapse'>
								<ul>
									<div><b>1. Добавлена поддержка Internet Explorer 11.0 (правда-правда)</b></div>
									<div><b>2. Добавлены всплывающие сообщения об отправке писем, добавлении рецензентов и т.п.</b></div>
									<div><b>3. Добавлена страница с детальной инфомрацией о рецензенте (клик по любой таблице с рецензентами), включающая перечень как рецензируемых, так и ранее отработанных статей</b></div>
									<div>И как обычно, десятки мелких исправлений...</div>
								</ul>
							</div>
							<div><a class='collapseheader' data-toggle='collapse' href='#upd3010'>&plus;Глобальное обновление "Мухи и Котлеты" от 30.10.2017</a></div>
							<div id='upd3010' class='panel-collapse collapse'>
								<ul>
									<div><b>По многочисленным просьбам проведена капитальная ревизия сайта</b></div>
									<div><b>1. Общее</b></div>
									<ul>
										<div>1.1. Сайт поделён на два главных блока: "Статьи" и "Рецензенты"</div>
									</ul>
									<ul>
										<div>1.2. Для технического редактора на главной странице добавлена возможность отправить претензии авторам</div>
									</ul>
									<ul>
										<div>1.3. Для всех действий добавлено окно-подтверждение (на всякий случай)</div>
									</ul>
									<div><b>2. Блок "Статьи"</b></div>
									<ul>
										<div><b>2.1. Пункт "Архив"</b></div>
										<ul>
											<div>2.1.1. Добавлен доступ ко всем архивным статьям журнала: раздел "весь архив" </div>
										</ul>
										<ul>
											<div>2.1.2. Добавлен доступ к конкретным архивным выпускам: разделы "40-4", "40-5"... </div>
										</ul>
										<ul>
											<div>2.1.3. Добавлен доступ к корзине (старые и забытые авторами статьи): раздел "корзина"</div>
										</ul>
										<ul>
											<div>2.1.4. Добавлен доступ к отклонённым статьям: раздел "отклонено"</div>
										</ul>
									</ul>
									<ul>
										<div><b>2.2. Пункт "Детальная информация о статье"</b></div>
										<ul>
											<div>2.2.1. При назначении рецензента встроен поиск по ключевым словам </div>
										</ul>
									</ul>
									<div><b>3. Блок "Рецензенты"</b></div>
									<ul>
										<div><b>3.1. Пункт "Перечень"</b></div>
										<ul>
											<div>3.1.1. Добавлен полный перечень рецензентов, включая интересы (будет дополняться в будущем)</div>
										</ul>
										<ul>
											<div>3.1.2. Добавлен умный поиск рецензентов по ключевым словам статей, отрецензированных ранее </div>
										</ul>
										<ul>
											<div>3.1.3. Добавлена возможность просмотра детальных сведений по рецензенту (клик по элементу списка) </div>
										</ul>
									</ul>
									<ul>
										<div><b>3.2. Пункт "Рейтинг"</b></div>
										<ul>
											<div>3.2.1. Пересчитан рейтинг рецензентов</div>
										</ul>
										<ul>
											<div>3.2.2. Добавлена информация об общем числе написанных рецензий</div>
										</ul>
									</ul>
									<ul>
										<div><b>3.3. Пункт "Выплаты"</b></div>
										<ul>
											<div>3.3.1. Обновлены выплаты с учётом последнего выпуска журнала "41-5"</div>
										</ul>
									</ul>

									<div><b>Сотня мелких исправлений</b></div>
								</ul>
							</div>
						</div>

						<div>
							<div><a class='collapseheader' data-toggle='collapse' href='#upd2410'>&plus;Обновление от 24.10.2017</a></div>
							<div id='upd2410' class='panel-collapse collapse'>
								<ul>
									<div><b>1. Портфель</b></div>
									<ul>
										<div>1.1. Добавлена возможность сортировки по разделам</div>
									</ul>
									<ul>
										<div>1.2. Добавлено отображение срока прохождения статьи</div>
									</ul>
									<div><b>2. Детальная информация по статье</b></div>
									<ul>
										<div>2.1. Добавлена возможность просмотра файлов статей/рецензий (доступно для всех новых статей/рецензий, а также для некоторых поступивших ранее)</div>
									</ul>
									<ul>
										<div>2.2. Добавлена возможность отклонения статьи редактором раздела</div>
									</ul>
									<div><b>3. Рецензенты</b></div>
									<ul>
										<div>3.1. Добавлена формула расчёта рейтинга рецензентов</div>
									</ul>
									<div><b>4. Прочее</b></div>
									<ul>
										<div>4.1. Множественные мелкие исправления</div>
									</ul>
								</ul>
							</div>
						</div>
						<div>
							<div><a class='collapseheader' data-toggle='collapse' href='#upd1710'>&plus;Обновление платформы 17.10.2017</a></div>
							<div id='upd1710' class='panel-collapse collapse'>
								<ul>
									<div>Новая версия мастер-сайта журнала "Компьютерная оптика" к Вашим услугам!</div>
									<div>По всем замечаниям и предложениям просьба обращаться по адресу 401-1к или co.kirshdv@gmail.com</div>
								</ul>
							</div>
						</div>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class='infblockdelim'></div>
</div>