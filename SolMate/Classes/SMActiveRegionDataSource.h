//
//  SMActiveRegionDataSource.h
//  SolMate
//
//  Created by Simon Free on 08/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "JSONDataSource.h"


@interface SMActiveRegionDataSource : JSONDataSource {

}
- (id)initWithDelegate:(id <JSONDataSourceDelegate>)aDelegate;
- (NSArray *)activeRegions;
@end
