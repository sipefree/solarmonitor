//
//  SMForecastDataSource.m
//  SolMate
//
//  Created by Simon Free on 28/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import "SMForecastDataSource.h"


@implementation SMForecastDataSource
- (id)initWithDelegate:(id <JSONDataSourceDelegate>)aDelegate {
	if((self = [super initWithURLString:@"http://solarmonitor.org/webservices/forecast.json.php" delegate:aDelegate]) != nil) {
		
	}
	return self;
}
@end
