//
//  SMActiveRegionDataSource.m
//  SolMate
//
//  Created by Simon Free on 08/06/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "SMActiveRegionDataSource.h"


@implementation SMActiveRegionDataSource
- (id)initWithDelegate:(id <JSONDataSourceDelegate>)aDelegate {
	if((self = [super initWithURLString:@"http://solarmonitor.org/webservices/active_regions.json.php" delegate:aDelegate]) != nil) {
		// init
	}
	return self;
}
- (NSArray *)activeRegions {
	NSDictionary* dict = (NSDictionary*)self.jsonObject;
	NSArray* regions = [dict objectForKey:@"regions"];
	return regions;
}
@end
